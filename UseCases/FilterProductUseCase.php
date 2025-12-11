<?php

namespace UseCases;

use App\Models\Product;

class FilterProductUseCase
{
    public function __construct(readonly private array $validated)
    {
    }

    public function do()
    {
        $query = Product::query();

        dd($query);

        return $query;
    }
}
