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
    <form style="margin-bottom: 20px;" class="form-inline col-md-12" action="{{ route('transaction.time') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-group col-md-5">
            <label for="from" class="col-md-4 col-form-label text-md-right">{{ __('From') }}</label>

            <div class="col-md-6">
                <input id="from" type="date" class="form-control{{ $errors->has('from') ? ' is-invalid' : '' }}" value="{{ date('Y-m-d') }}" name="from"  autofocus>
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
                <input id="end" type="date" class="form-control{{ $errors->has('end') ? ' is-invalid' : '' }}" value="{{ date('Y-m-d') }}" name="end"  autofocus>
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
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
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
                    <th scope="row">{{ $transaction->id }}</th>
                    <td>{{ date('d/m/Y',strtotime($transaction->transaction_at)) }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>
                        @if($transaction->categories->type === 0)
                            <i style="color:green" class="fas fa-forward"></i>
                        @else
                            <i style="color: red" class="fas fa-backward"></i>
                        @endif
                            <a href="{{ route('transaction.category',['id' => $transaction->categories->id]) }}">{{ $transaction->categories->name }}</a>
                    </td>
                    <td><a href="{{ route('wallet.index') }}">{{ $transaction->wallets->name }}</a></td>
                    <td>
                        <a class="badge badge-primary" href="{{ route('transaction.edit',['id'=>$transaction->id]) }}">EDIT</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a class="badge badge-danger" href="{{ route('transaction.delete',['id'=>$transaction->id]) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
