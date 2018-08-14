@extends('layouts.base')

@section('content')
    <style>
        .float{
            position:fixed;
            width:60px;
            height:60px;
            bottom:40px;
            right:40px;
            background-color:#0C9;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            box-shadow: 2px 2px 3px #999;
        }
    </style>
    <a href="{{route('wallet.create')}}" class="float">
        <i style="margin-top: 22px" class="fa fa-plus my-float"></i>
    </a>
    @foreach($wallets as $wallet)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <i class="fas fa-credit-card"></i>
                        &nbsp;&nbsp;&nbsp;
                        {{ $wallet->name }}
                        <div class="card-actions">
                            <a href="{{ route('wallet.history',['id'=> $wallet->id]) }}">
                                <i class="fas fa-history"></i>
                            </a>
                            <a href="{{ route('transfer.create',['id' => $wallet->id]) }}" class="btn">
                                <i class="fas fa-exchange-alt"></i>
                            </a>

                            <a href="{{ route('wallet.edit',['id' => $wallet->id]) }}" class="btn">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <a href="{{ route('wallet.delete',['id' => $wallet->id]) }}" onclick="return confirm('Are you sure to delete this wallet?')" class="btn">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ number_format($wallet->balance) }}
                    </div>
                </div>
            </div>
    @endforeach

@endsection