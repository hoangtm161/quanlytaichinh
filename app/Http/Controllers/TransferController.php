<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\TransferRequest;
use App\Transfer;
use App\User;
use App\Wallet;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transfers = Transfer::with(['send_wallets', 'receive_wallets'])
            ->whereIn('wallets_send_id_foreign', function ($query) {
                $query->select('id')
                    ->from('wallets')
                    ->where('users_id_foreign', Auth::id());
            })->orWhereIn('wallets_receive_id_foreign', function ($query) {
                $query->select('id')
                    ->from('wallets')
                    ->where('users_id_foreign', Auth::id());
            })->get();
        return view('wallet.transfer_index', compact('transfers'));
    }

    public function findWalletByUserID(int $id)
    {
        return User::findOrFail($id)->wallets;
    }

    public function checkBalance(int $walletId, float $amount): bool
    {
        $wallet = Wallet::findOrFail($walletId);
        if ($wallet->balance >= $amount) {
            return true;
        }
        return false;
    }

    public function checkPolicy(String $ability, Wallet $wallet): bool
    {
        if (Auth::user()->can($ability, $wallet)) {
            return true;
        }
        return false;
    }

    public function addMoney(int $id, float $amount)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->balance += $amount;
        $wallet->save();
    }

    public function subMoney(int $id, float $amount)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->balance -= $amount;
        $wallet->save();
    }

    public function transfer(int $transferId)
    {
        $transfer = Transfer::findOrFail($transferId);
        $this->subMoney($transfer->wallets_send_id_foreign, $transfer->amount);
        $this->addMoney($transfer->wallets_receive_id_foreign, $transfer->amount);
    }

    public function store(int $id, TransferRequest $request)
    {
        $wallet = Wallet::findOrFail($id);
        if (!$this->checkPolicy('storeTransfer', $wallet)) {
            return view('not_authorization');
        }
        if (!$this->checkBalance($id, (float)$request->input('amount'))) {
            return redirect()->back()
                ->with('status-fail', 'The transfer amount is greater than current balance');
        }
        $validatedData = $request->validated();
        $validatedData['wallets_send_id_foreign'] = $id;

        $transferId = Transfer::create($validatedData)->id;
        $this->transfer($transferId);

        return redirect()->route('wallet.index')->with('status', 'Money transferd');
    }

    public function create(int $id)
    {
        $wallet = Wallet::findOrFail($id);
        if (!$this->checkPolicy('transfer', $wallet)) {
            return view('not_authorization');
        }
        $wallets = Wallet::where('users_id_foreign', Auth::id())
            ->where('id', '<>', $id)->get();
        if ($wallet->balance <= 0) {
            return redirect()->back()->with('status-fail', 'This wallet is not enought money');
        }
        return view('wallet.transfer', compact(['wallet', 'wallets']));
    }
}
