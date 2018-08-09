@extends('layouts.base')

@section('content')
    <style>
        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #0C9;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            box-shadow: 2px 2px 3px #999;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a style="text-decoration: none" href="{{ route('transaction.index') }}"><i class="fas fa-chevron-left mb-3"></i>&nbsp;All transactions</a>
                @if(count($transactions) === 0)
                    <h4 style="text-align: center" class="mt-3">There no transaction
                    </h4>
                @else
                <div class="card">
                    <div class="card-header bg-light">All transanctions</div>
                    <div class="card-body">
                        <div class="col-md-12 mb-3" style="text-align: center">
                            <label class="badge badge-success">Total
                                income: </label>&nbsp;&nbsp;&nbsp;<span>{{ number_format($totalIncome) }}</span>
                            <label style="margin-left: 20px" class="badge badge-danger">Total
                                expense: </label>&nbsp;&nbsp;&nbsp;<span>{{ number_format($totalExpense) }}</span>
                        </div>
                        <form style="margin-bottom: 20px;" class="form-inline col-md-12"
                              action="{{ route('transaction.time') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group col-md-5">
                                <label for="from" class="col-md-4 col-form-label text-md-right">{{ __('From') }}</label>

                                <div class="col-md-6">
                                    <input id="from" type="date"
                                           class="form-control{{ $errors->has('from') ? ' is-invalid' : '' }}"
                                           value="{{ date('Y-m-d',strtotime(date('Y-m-d').' -30 days')) }}" name="from"
                                           autofocus>
                                    @if ($errors->has('from'))
                                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('from') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-5">
                                <label for="end" class="col-md-4 col-form-label text-md-right">{{ __('To') }}</label>

                                <div class="col-md-6">
                                    <input id="end" type="date"
                                           class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}"
                                           value="{{ date('Y-m-d') }}" name="end" autofocus>
                                    @if ($errors->has('end'))
                                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('end') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Show') }}
                                    </button>
                                </div>
                            </div>

                            <div style="margin-left: 10px;" class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('transaction.index') }}" class="btn btn-info">
                                        {{ __('Clear') }}
                                    </a>
                                </div>
                            </div>

                        </form>
                        <table class="table table-hover table-responsive-md border rounded">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Transact date</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Description</th>
                                <th scope="col">Category</th>
                                <th scope="col">Wallet</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <th scope="row">{{ date('d/m/Y',strtotime($transaction->transaction_at)) }}</th>
                                    <td>
                                        <label class="badge {{$transaction->categories->type === 0 ? 'badge-success':'badge-danger'}} ">
                                            <i class="fas  {{ $transaction->categories->type === 0 ? 'fa-plus':'fa-minus' }}"></i>
                                        </label>
                                        &nbsp;&nbsp;{{ number_format($transaction->amount) }}
                                    </td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>
                                        @if($transaction->categories->type === 0)
                                            <i class="fas fa-forward text-success"></i>
                                        @else
                                            <i class="fas fa-backward text-danger"></i>
                                        @endif
                                        <a href="{{ route('transaction.category',['id' => $transaction->categories->id]) }}">{{ $transaction->categories->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('wallet.history',['id' => $transaction->wallets_id_foreign]) }}">{{ $transaction->wallets->name }}</a>
                                    </td>
                                    <td>
                                        <a class="text-primary"
                                           href="{{ route('transaction.edit',['id'=>$transaction->id]) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="text-danger"
                                           href="{{ route('transaction.delete',['id'=>$transaction->id]) }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <a href="{{route('transaction.create')}}" class="float">
        <i style="margin-top: 22px" class="fa fa-plus my-float"></i>
    </a>
@endsection
