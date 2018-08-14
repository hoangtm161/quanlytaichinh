<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class WalletRequest extends FormRequest
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
        if ($route->getActionMethod() === 'update') {
            return [
                'name' => 'required|max:50|min:6',
            ];
        }
        return [
            'name' => 'required|max:50|min:6',
            'balance' => 'required|numeric'
        ];
    }
}
