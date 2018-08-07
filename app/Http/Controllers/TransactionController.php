<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\TransactionRequest;
use App\Transaction;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transactions= Transaction::whereIn('wallets_id_foreign', function($query){
            $query->select('id')
                ->from('wallets')
                ->where('users_id_foreign', Auth::id());
        })->get();

        return view('transaction.index', compact('transactions'));
    }

    public function create()
    {
        $categories_income = Category::where('users_id_foreign',Auth::id())
            ->where('type',0)->get();

        $categories_expense = Category::where('users_id_foreign',Auth::id())
            ->where('type',1)->get();

        $wallets = Wallet::where('users_id_foreign', Auth::id())->get();

        return view('transaction.create',compact('categories_income','categories_expense','wallets'));
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

    protected function getType(int $categoryId)
    {
        return Category::findOrFail($categoryId)->type;
    }

    protected function transact(int $transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        if ($this->getType($transaction->categories_id_foreign) === 0) {
            $this->addMoney($transaction->wallets_id_foreign, $transaction->amount);
        } else if ($this->getType($transaction->categories_id_foreign) === 1) {
            $this->subMoney($transaction->wallets_id_foreign, $transaction->amount);
        }
        $transaction->save();
    }

    public function store(TransactionRequest $request)
    {
        $validatedData = $request->validated();
        $newTranactionId = Transaction::create($validatedData)->id;
        $this->transact($newTranactionId);
        return redirect()->route('transaction.index');
    }
}
