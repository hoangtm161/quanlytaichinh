@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">Add new transation</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('status-fail'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('status-fail') }}
                            </div>
                        @endif
                        <form style="margin-top: 25px;" method="POST" action="{{route('transaction.update',['id' => $transaction->id])}}" aria-label="{{ __('Register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>
                                <div class="col-md-6">
                                    <input  id="amount" type="number" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ $transaction->amount }}" name="amount" autofocus required>

                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>
                                <div class="col-md-6">
                                    <select name="categories_id_foreign" class="form-control">
                                        @foreach($categories_income as $category)
                                            <option {{ $category->id === $transaction->categories_id_foreign ? 'selected':''  }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                        <option value="">----Expense----</option>
                                        @foreach($categories_expense as $category)
                                            <option {{ $category->id === $transaction->categories_id_foreign ? 'selected':''  }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="wallet" class="col-md-4 col-form-label text-md-right">{{ __('Wallet') }}</label>
                                <div class="col-md-6">
                                    <select name="wallets_id_foreign" class="form-control">
                                        @foreach($wallets as $wallet)
                                            <option value="{{ $wallet->id }}">{{ $wallet->name.': '.number_format($wallet->balance) }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('wallets'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('wallets') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                                <div class="col-md-6">
                                    <input  id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ $transaction->description }}" name="description" autofocus required>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="transaction_at" class="col-md-4 col-form-label text-md-right">{{ __('Transact Date') }}</label>

                                <div class="col-md-6">
                                    <input id="transaction_at" value="{{ date('Y-m-d',strtotime($transaction->transaction_at)) }}" type="date" class="form-control{{ $errors->has('transaction_at') ? ' is-invalid' : '' }}" name="transaction_at"  required>
                                    @if ($errors->has('transaction_at'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('transaction_at') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save change') }}
                                    </button>
                                    <a href="{{route('transaction.delete',['id' => $transaction->id])}}" class="m-2 btn btn-danger">
                                        {{ __('Delete') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
