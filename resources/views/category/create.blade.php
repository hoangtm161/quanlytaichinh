@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-light">Add new wallet</div>
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
                        <form style="margin-top: 25px;" method="POST" action="{{route('category.store')}}" aria-label="{{ __('Register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="categories_parent_id" class="col-md-4 col-form-label text-md-right">{{ __('Parent Category') }}</label>
                                <div class="col-md-6">
                                    <select name="categories_parent_id" class="form-control">
                                        <option value="">None</option>
                                        @foreach($categories as $category)
                                            @if($category->categories_parent_id === null)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                            @foreach($categories as $category2)
                                                @if($category2->categories_parent_id == $category->id)
                                                    <option value="{{ $category2->id }}">&nbsp;&nbsp;&nbsp;{{$category2->name}}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
                                <div class="col-md-6" style="margin-top: 5px;">
                                    <label><input type="radio" value="0" name="type">&nbsp;Income</label>&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" value="1" name="type">&nbsp;Expense</label>
                                @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Category Name') }}</label>
                                <div class="col-md-6">
                                    <input  id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" autofocus required>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add new category') }}
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
