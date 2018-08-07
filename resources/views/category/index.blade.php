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
    <a href="{{route('category.create')}}" class="float">
        <i style="margin-top: 22px" class="fa fa-plus my-float"></i>
    </a>
            <div class="list-group col-md-6">
                <a href="#" class="list-group-item list-group-item-action active">Income</a>
                @foreach($categories_income as $category)
                    <a href="{{ route('category.edit',['id' => $category->id]) }}" class="list-group-item list-group-item-action">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="list-group col-md-6">
                <a href="#" class="list-group-item list-group-item-action active">Expense</a>
                @foreach($categories_expense as $category)
                    <a href="{{ route('category.edit',['id' => $category->id]) }}" class="list-group-item list-group-item-action">{{ $category->name }}</a>
                @endforeach
            </div>

@endsection