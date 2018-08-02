<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
}
