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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wallets = Wallet::where('users_id_foreign', Auth::id())->get();
        return view('wallet.index', compact('wallets'));
    }

    public function create()
    {
        return view('wallet.create');
    }

    public function store(WalletRequest $request)
    {
        if (Wallet::where('name', $request->input('name'))
            ->where('users_id_foreign', Auth::id())->first()) {
            return redirect()->back()->with('status-fail', 'This name already taken');
        }
        $validatedData = $request->all();
        $validatedData['users_id_foreign'] = Auth::id();
        Wallet::create($validatedData);
        return redirect()->route('wallet.index');
    }

    public function edit(int $id)
    {
        $user = Auth::user();
        $wallet = Wallet::findOrFail($id);
        if ($user->can('update', $wallet)) {
            return view('wallet.edit', compact('wallet'));
        }
        return view('not_authorization');
    }

    public function update(int $id, WalletRequest $request)
    {
        $user = Auth::user();
        $wallet = Wallet::findOrFail($id);
        if ($user->can('update', $wallet)) {
            if (Wallet::where('name', $request->input('name'))
                ->where('users_id_foreign', Auth::id())->first()) {
                return redirect()->back()->with('status-fail', 'This name already taken');
            }
            $wallet->update($request->validated());
            return redirect()->route('wallet.index');
        }
        return view('not_authorization');
    }

    public function delete($id)
    {
        $wallet = Wallet::findOrFail($id);
        if (Auth::user()->can('delete', $wallet)) {
            $transfers = Transfer::where('wallets_send_id_foreign', $id)
                ->orWhere('wallets_receive_id_foreign', $id)->get();
            $transaction = Transaction::where('wallets_id_foreign', $id)->get();
            if (count($transfers) > 0 || count($transaction) > 0) {
                return redirect()->route('wallet.index')->with('status-fail', 'Cannot delete this wallet');
            }
            $wallet->delete();
        }
        return redirect()->route('wallet.index')->with('status', 'Delete successfully');
    }

    public function showHistory(int $walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        if (Auth::user()->can('view', $wallet)) {
            $transactions = Transaction::whereIn('wallets_id_foreign', function ($query) {
                $query->select('id')
                    ->from('wallets')
                    ->where('users_id_foreign', Auth::id());
            })->where('wallets_id_foreign', $walletId)->orderByDesc('transaction_at')
                ->orderByDesc('id')->paginate(10);
            return view('transaction.index', compact('transactions', 'wallet'));
        }
        return view('not_authorization');
    }
}
