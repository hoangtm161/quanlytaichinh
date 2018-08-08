<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use App\Transaction;
use App\User;
use App\Wallet;
use Illuminate\Support\Facades\Auth;
use App\Transfer;

class WalletController extends Controller
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
        $wallets = User::find(Auth::id())->wallets;
        return view('wallet.index',compact('wallets'));
    }

    public function create()
    {
        return view('wallet.create');
    }

    public function store(WalletRequest $request)
    {
        if (Wallet::where('name', $request->input('name'))->first()) {
            return redirect()->back()->with('status-fail','This name already taken');
        }
        $validatedData = $request->all();
        $validatedData['users_id_foreign']=Auth::id();
        Wallet::create($validatedData);
        return redirect()->route('wallet.index');
    }

    public function edit(int $id)
    {
        $user = Auth::user();
        $wallet = Wallet::findOrFail($id);
        if ($user->can('update',$wallet)) {
            return view('wallet.edit',compact('wallet'));
        }
        return view('not_authorization');
    }

    public function update(int $id, WalletRequest $request)
    {
        $user = Auth::user();
        $wallet = Wallet::findOrFail($id);
        if ($user->can('update',$wallet)) {
            if (Wallet::where('name',$request->input('name'))->first()) {
                return redirect()->back()->with('status-fail','This name already taken');
            }
            $wallet->update($request->validated());
            return redirect()->route('wallet.index');
        }
        return view('not_authorization');
    }

    public function delete($id)
    {
        $wallet = Wallet::findOrFail($id);
        if (Auth::user()->can('delete',$wallet)) {
            $transfers = Transfer::where('wallets_send_id_foreign',$id)
                ->orWhere('wallets_receive_id_foreign',$id)->get();
            $transaction = Transaction::where('wallets_id_foreign', $id)->get();
            if (count($transfers) > 0 || count($transaction) > 0) {
                return redirect()->route('wallet.index')->with('status-fail','Cannot delete this wallet');
            }
            $wallet->delete();
        }
        return redirect()->route('wallet.index')->with('status','Delete successfully');
    }

    public function showHistory(int $walletId)
    {
        $transactions= Transaction::whereIn('wallets_id_foreign', function($query){
            $query->select('id')
                ->from('wallets')
                ->where('users_id_foreign', Auth::id());
        })->where('wallets_id_foreign',$walletId)->get();
        return view('transaction.index', compact('transactions'));
    }
}
