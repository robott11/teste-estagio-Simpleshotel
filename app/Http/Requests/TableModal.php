<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class TableModal extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'table_id' => 'required|numeric',
            'clients' => 'required|numeric'
        ];

        $products = Product::all();
        foreach ($products as $product) {
            $productField = 'product'. $product->id;
            $rules[$productField] = 'required|numeric';
        }

        return $rules;
    }
}
