<?php

namespace App\Http\Controllers;

use App\Category;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->category_income = config('app.category_income');
        $this->category_expense = config('app.category_expense');
    }
    public function index()
    {
        //0 = income, 1 = expense
        $categories_income = Category::where('type',$this->category_income)
            ->where('users_id_foreign', Auth::id())->get();
        $categories_expense = Category::where('type',$this->category_expense)
            ->where('users_id_foreign', Auth::id())->get();

        return view('category.index',compact('categories_income','categories_expense'));
    }

    public function create()
    {
        $categories = Category::all()->where('users_id_foreign', Auth::id());
        return view('category.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'type' => 'required',
        ]);
        Category::create([
            'name' => $validatedData['name'],
            'type' => $request->input('type'),
            'categories_parent_id' => $request->input('categories_parent_id'),
            'users_id_foreign' => \Auth::id(),
        ]);
        return redirect()->route('category.index');
    }

    public function edit(int $id)
    {
        $categories = Category::all()->where('users_id_foreign', Auth::id());
        $current_category = Category::findOrFail($id);
        if (Auth::user()->can('update',$current_category)) {
            return view('category.edit',compact('current_category','categories'));
        }
        return view('not_authorization');
    }

    public function update(int $id, Request $request)
    {
        $category = Category::findOrFail($id);
        if (Auth::user()->can('update',$category)) {
            $validatedData = $request->validate([
                'name' => 'required|max:50',
                'type' => 'required'
            ]);
            $category->update([
                'name' => $validatedData['name'],
                'type' => $request->input('type'),
                'categories_parent_id' => $request->input('categories_parent_id'),
                'users_id_foreign' => \Auth::id(),
            ]);
            return redirect()->route('category.index');
        }
        return view('not_authorization');
    }

    public function delete(int $id)
    {
        $category = Category::findOrFail($id);
        if (count(Transaction::where('categories_id_foreign', $id)->get())) {
            return redirect()->route('category.index')->with('status-fail','Disabled');
        }
        $category->delete();
        return redirect()->route('category.index')->with('status','Category deleted');
    }

}
