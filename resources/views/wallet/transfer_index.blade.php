@extends('layouts.base')

@section('content')
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Description</th>
            <th scope="col">Amount</th>
            <th scope="col">Send Wallet</th>
            <th scope="col">Receive Wallet</th>
            <th scope="col">Transfer date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transfers as $transfer)
            <tr>
                <th scope="row">{{ $transfer->id }}</th>
                <td>{{ $transfer->description }}</td>
                <td>{{ $transfer->amount }}</td>
                <td>
                    <i style="color:red" class="fas fa-forward"></i>
                    {{ $transfer->send_wallets->name }}
                </td>
                <td>
                    <i style="color:green" class="fas fa-forward"></i>
                    {{ $transfer->receive_wallets->name }}
                </td>
                <td>{{ date('d/m/Y',strtotime($transfer->created_at)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>




@endsection
