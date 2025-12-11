<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Product\FilterRequest;
use App\Models\Product;
use App\UseCases\FilterProductUseCase;
use Mockery\Exception;


class ProductController extends Controller
{
    /**
     * @param FilterRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(FilterRequest $request)
    {
        try {
            $validated = $request->validated();
            $result = (new FilterProductUseCase($validated))->do();

            return response()->json($result->cursorPaginate(5), 200);

        } catch (Exception $exception) {
            return response($exception->getMessage(), $exception->getCode());
        }

    }

}
