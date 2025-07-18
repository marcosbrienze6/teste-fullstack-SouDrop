<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    protected $productModel;

    public function __construct(Product $productModel) {
        $this->productModel = $productModel;
    }

    public function store(array $data)
    {
        $product = $this->productModel->create($data);

        return $product;
    }

    public function getByFilter($data)
    {
        $query = Product::with('user');

        if ($data) {
            $query->where(function ($q) use ($data) {
                $q->where('name', 'LIKE', "%{$data}%")
                ->orWhere('type', $data)
                ->orWhere('description', $data)
                ->orWhere('color', $data);
            });
        }

        return $query->paginate(10);
    }

    public function update(array $data, int $productId)
    {
        $product = Product::findOrFail($productId);
        $product->load('user');
        $product->update($data);

        return $product;
    }

    public function delete(int $productId)
    {
        $product = Product::findOrFail($productId);
        $product->delete();

        return $product;
    }
}