<?php

namespace App\Http\Requests\Api\Product;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    /**
     * Кастомизируем валидацию под наш случай
     *
     * @throws Exception
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if (isset($validated['price_from']) && isset($validated['price_to'])
            && $validated['price_from'] > $validated['price_to']) {

            throw new Exception('Price should be greater than Price From', 409);

        }

        return $validated;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string'],
            'price_from' => ['nullable', 'numeric'],
            'price_to' => ['nullable', 'numeric'],
            'rating_from' => ['nullable', 'numeric'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'ib_stock' => ['nullable', 'boolean'],
            'sort' => ['nullable', Rule::in([
                'price_asc'
                , 'price_desc'
                , 'rating_desc'
                , 'newest'
            ])]
        ];
    }
}
