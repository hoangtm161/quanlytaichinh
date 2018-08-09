<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\TransactionRequest;
use App\Transaction;
use App\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $category_income;
    private $category_expense;

    public function __construct()
    {
        $this->middleware('auth');
        $this->category_income = config('app.category_income');
        $this->category_expense = config('app.category_expense');
    }

    public function index()
    {
        $transactions = Transaction::with('categories', 'wallets')
            ->whereIn('wallets_id_foreign', function ($query) {
                $query->select('id')
                    ->from('wallets')
                    ->where('users_id_foreign', Auth::id());
            })->orderByDesc('transaction_at')->orderByDesc('id')->get();

        return view('transaction.index', compact('transactions'));
    }

    public function create()
    {
        $categories_income = Category::where('users_id_foreign', Auth::id())
            ->where('type', $this->category_income)->get();

        $categories_expense = Category::where('users_id_foreign', Auth::id())
            ->where('type', $this->category_expense)->get();
        $wallets = Wallet::where('users_id_foreign', Auth::id())->get();

        return view('transaction.create', compact('categories_income', 'categories_expense', 'wallets'));
    }

    protected function addMoney(int $walletId, float $amount)
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->balance += $amount;
        $wallet->save();
    }

    protected function subMoney(int $walletId, float $amount)
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->balance -= $amount;
        $wallet->save();
    }

    protected function getType(int $categoryId): String
    {
        return Category::findOrFail($categoryId)->type;
    }

    protected function revertTransaction(int $transactionId): void
    {
        $transaction = Transaction::findOrFail($transactionId);

        if ($this->getType($transaction->categories_id_foreign) === $this->category_expense) {
            $this->addMoney($transaction->wallets_id_foreign, $transaction->amount);
        } elseif ($this->getType($transaction->categories_id_foreign) === $this->category_income) {
            $this->subMoney($transaction->wallets_id_foreign, $transaction->amount);
        }

        $transaction->save();
    }

    protected function transact(int $transactionId): void
    {
        $transaction = Transaction::findOrFail($transactionId);
        if ($this->getType($transaction->categories_id_foreign) === $this->category_income) {
            $this->addMoney($transaction->wallets_id_foreign, $transaction->amount);
        } elseif ($this->getType($transaction->categories_id_foreign) === $this->category_expense) {
            $this->subMoney($transaction->wallets_id_foreign, $transaction->amount);
        }
    }

    public function store(TransactionRequest $request)
    {
        $validatedData = $request->validated();
        $newTranactionId = Transaction::create($validatedData)->id;
        $this->transact($newTranactionId);
        return redirect()->route('transaction.index');
    }

    public function edit(int $id)
    {
        $transaction = Transaction::findOrFail($id);
        $wallet = Wallet::findOrFail($transaction->wallets_id_foreign);
        if (!Auth::user()->can('delete', $wallet)) {
            return view('not_authorization');
        }
        $categories_income = Category::where('users_id_foreign', Auth::id())
            ->where('type', $this->category_income)->get();
        $categories_expense = Category::where('users_id_foreign', Auth::id())
            ->where('type', $this->category_expense)->get();
        $wallets = Wallet::where('users_id_foreign', Auth::id())->get();
        return view('transaction.edit', compact('transaction', 'categories_income', 'categories_expense', 'wallets'));
    }

    public function update(int $id, TransactionRequest $request)
    {
        $transaction = Transaction::findOrFail($id);
        $wallet = Wallet::findOrFail($transaction->wallets_id_foreign);
        if (!Auth::user()->can('delete', $wallet)) {
            return view('not_authorization');
        }
        $this->revertTransaction($id);
        $validatedData = $request->validated();
        $transaction->update($validatedData);
        $this->transact($id);
        return redirect()->route('transaction.index')->with('status', 'Transaction updated');
    }

    public function delete(int $id)
    {
        $transaction = Transaction::findOrFail($id);
        $wallet = Wallet::findOrFail($transaction->wallets_id_foreign);
        if (!Auth::user()->can('delete', $wallet)) {
            return view('not_authorization');
        }
        $this->revertTransaction($id);
        $transaction->delete();
        return redirect()->route('transaction.index')->with('status', 'Transaction deleted');
    }

    public function showTransactionByCategory(int $categoryId)
    {
        $transactions = Transaction::with('categories', 'wallets')
            ->whereIn('wallets_id_foreign', function ($query) {
                $query->select('id')
                    ->from('wallets')
                    ->where('users_id_foreign', Auth::id());
            })->where('categories_id_foreign', $categoryId)->get();

        return view('transaction.index', compact('transactions'));
    }

    public function showTransactionByTime(Request $request)
    {
        $from = $request->input('from');
        $end = $request->input('end');

        if ($from > $end) {
            return redirect()->route('transaction.index')->with('status-fail',
                'Start time must before or equal end time');
        }
        $transactions = Transaction::with('categories', 'wallets')
            ->whereIn('wallets_id_foreign', function ($query) {
                $query->select('id')
                    ->from('wallets')
                    ->where('users_id_foreign', Auth::id());
            })->whereBetween('transaction_at', [$from, $end])->get();
        return view('transaction.index', compact('transactions'));
    }
}