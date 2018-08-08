<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class TransactionRequest extends FormRequest
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
                'amount' => 'required|numeric',
                'description' => 'required|max:100',
                'transaction_at' => '|required|date',
                'categories_id_foreign' => 'required|numeric',
            ];
        }
        return [
            'amount' => 'required|numeric',
            'description' => 'required|max:100',
            'transaction_at' => '|required|date',
            'categories_id_foreign' => 'required|numeric',
            'wallets_id_foreign' => 'required|numeric',
        ];
    }
}
