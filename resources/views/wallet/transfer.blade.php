@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">Transfer money</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="wallet" class="col-md-4 col-form-label text-md-right">{{ __('Send Wallet') }}</label>
                            <div class="col-md-6">
                                <input id="" type="text" class="form-control{{ $errors->has('') ? ' is-invalid' : '' }}" value="{{ $wallet->name }}" disabled>
                                <span>Balance </span><label class="badge badge-danger">{{ number_format($wallet->balance) }}</label>
                            </div>
                        </div>
                        <form style="margin-top: 10px;" method="POST" action="{{ route('transfer.store',['id' => $wallet->id ]) }}" aria-label="{{ __('Register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="receive" class="col-md-4 col-form-label text-md-right">{{ __('Receive Wallet') }}</label>
                                <div class="col-md-6">
                                    <select name="wallets_receive_id_foreign" class="form-control">
                                        @foreach($wallets as $wallet_receive)
                                        <option value="{{ $wallet_receive->id }}">{{ $wallet_receive->name }}</option>
                                        @endforeach;
                                    </select>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                                <div class="col-md-6">
                                    <input id="description" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>

                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>
                                <div class="col-md-6">
                                    <input id="" type="number" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" required>

                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Transfer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
