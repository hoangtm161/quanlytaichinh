<?php

namespace App\Http\Requests;

use Illuminate\Routing\Route;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Route $route)
    {
        if ($route->getActionMethod() === 'update'){
            return [
                'name' => 'max:50|nullable',
                'address' => 'max:100|nullable',
                'phone_number' => 'numeric|nullable',
                'avatar' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',
                'dob' => 'date|nullable',
            ];
        }

        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'max:50|nullable',
            'address' => 'max:100|nullable',
            'phone_number' => 'numeric|nullable',
            'avatar' => 'image|mimes:jpeg,png,jpg|max:2048|nullable',
            'dob' => 'date|nullable',
        ];
    }
}
