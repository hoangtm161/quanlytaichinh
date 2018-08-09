@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">All transfers</div>
                    @if(count($transfers) === 0)
                        <h4 style="text-align: center" class="mt-3">There no transfer
                        </h4>
                    @else
                        <div class="card-body">
                            <table class="table table-hover table-responsive-md border-0 rounded">
                                <thead>
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
                                        <td>{{ number_format($transfer->amount) }}</td>
                                        <td>
                                            <i class="fas fa-forward text-danger"></i>
                                            {{ $transfer->send_wallets->name }}
                                        </td>
                                        <td>
                                            <i class="fas fa-forward text-success"></i>
                                            {{ $transfer->receive_wallets->name }}
                                        </td>
                                        <td>{{ date('d/m/Y',strtotime($transfer->created_at)) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
