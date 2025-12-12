<?php

namespace App\UseCases;

use App\Models\Product;

class FilterProductUseCase
{

    private const PAGE_SIZE = 2;

    public function __construct(readonly private array $validated)
    {
    }

    public function do()
    {
        $query = Product::query();

        if (isset($this->validated['in_stock'])) {
            $query = $query->where('in_stock', $this->validated['in_stock']);
        }

        if (isset($this->validated['price_from'])) {
            $query = $query->where('price', '>=', $this->validated['price_from']);
        }

        if (isset($this->validated['price_to'])) {
            $query = $query->where('price', '<=', $this->validated['price_to']);
        }

        if (isset($this->validated['rating_from'])) {
            $query = $query->where('rating', '>=', $this->validated['rating_from']);
        }

        // Умышлено на последнем месте в фильтре, т.к. LIKE медленный. В надежде, что набор данных к этому моменту будет прилично урезан предыдущими быстрыми фильтрами
        if (isset($this->validated['q'])) {
            $query = $query->whereLike('name', '%' . $this->validated['q'] . '%');
        }

        if (isset($this->validated['sort'])) {
            switch ($this->validated['sort']) {
                case 'price_asc':
                    $query = $query->orderBy('price');
                    break;
                case 'price_desc':
                    $query = $query->orderByDesc('price');
                    break;
                case 'rating_desc':
                    $query = $query->orderByDesc('rating');
                    break;
                case 'newest':
                    $query = $query->orderByDesc('created_at');
                    break;
            }
        }

        return $query->cursorPaginate(self::PAGE_SIZE)->withQueryString();
    }
}
