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
        $user = Auth::user();
        throw_if(!$user, new \Exception('Usuário não autenticado.'));

        $product = $this->productModel->create(array_merge(
            $data, ['user_id' => $user->id]
        ));

        $product->load('user');

        return $product;
    }

    public function getByFilter(array $data)
    {
        if ($data) {
           return Product::where('name', 'LIKE', "%{$data}%")
                ->orWhere('type', $data)
                ->orWhere('color', $data)
                ->get();
        } 
        
        return Product::all();
    }

    public function update(array $data, int $productId)
    {
        $user = Auth::user();
        throw_if(!$user, new \Exception('Usuário não autenticado.'));

        $product = Product::findOrFail($productId);
        $product->load('user');
        $product->update($data);

        return $product;
    }

    public function delete(int $productId)
    {
        $user = Auth::user();
        throw_if(!$user, new \Exception('Usuário não autenticado.'));

        $product = Product::findOrFail($productId);
        $product->delete();
    }
}