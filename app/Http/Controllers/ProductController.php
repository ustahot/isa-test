<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Product\FilterRequest;
use App\Models\Product;
use UseCases\FilterProductUseCase;


class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function filter(FilterRequest $request)
    {
        return (new FilterProductUseCase($request->validated()))->do();
    }
}
