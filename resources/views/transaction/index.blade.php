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
    <a href="{{route('transaction.create')}}" class="float">
        <i style="margin-top: 22px" class="fa fa-plus my-float"></i>
    </a>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Amount</th>
                <th scope="col">Description</th>
                <th scope="col">Category</th>
                <th scope="col">Wallet</th>
                <th scope="col">Transact date</th>

            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <th scope="row">{{ $transaction->id }}</th>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>
                        @if($transaction->categories->type === 0)
                            <i style="color:green" class="fas fa-forward"></i>
                        @else
                            <i style="color: red" class="fas fas fa-backward"></i>
                        @endif
                            {{ $transaction->categories->name }}
                    </td>
                    <td>{{ $transaction->wallets->name }}</td>
                    <td>{{ $transaction->transaction_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
