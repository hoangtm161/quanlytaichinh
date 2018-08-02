@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add new wallet</div>
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
                        <form style="margin-top: 25px;" method="POST" action="{{route('wallet.store')}}" aria-label="{{ __('Register') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Wallet Name') }}</label>
                                <div class="col-md-6">
                                    <input  id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" autofocus required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="balance" class="col-md-4 col-form-label text-md-right">{{ __('Initial Balance') }}</label>
                                <div class="col-md-6">
                                    <input id="balance" type="number" class="form-control{{ $errors->has('balance') ? ' is-invalid' : '' }}" name="balance">

                                    @if ($errors->has('balance'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('balance') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add new wallet') }}
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
