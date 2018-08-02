<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
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

    }

    public function create()
    {
        return view('wallet.add');
    }

    public function store(WalletRequest $request)
    {
        dd($request);
        Wallet::create([
            'name' => $request->input('wallet'),
            'balance' => $request->input('balance'),
            'users_id_foreign' => Auth::id(),
        ]);
    }
}
