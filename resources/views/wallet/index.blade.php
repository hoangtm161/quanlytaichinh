@extends('layouts.base')

@section('content')
    @foreach($wallets as $wallet)
        <div class="col-md-3">
            <div class="card p-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <a href="#">
                        <div style="display: inline-block">
                            <i class="fas fa-wallet h4"></i>
                            <span class="h4 d-block font-weight-normal mb-2">{{$wallet->name}}</span>
                            <span class="font-weight-light">{{$wallet->balance}}</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endforeach

@endsection