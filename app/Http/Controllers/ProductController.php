<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function store(CreateProductRequest $request)
    {
        $data = $request->validated();

        $product = $this->productService->store($data);

        return response()->json([
            'error' => false,
            'message' => 'Produto criado com sucesso',
            'product' => $product
        ]);
    }

    public function index(Request $request):JsonResponse
    {
        $validated = $request->validate([
            'filter' => 'nullable|string'
        ]);

        $data = $validated['filter'] ?? null;

        $product = $this->productService->getByFilter($data);

        return response()->json([
            'error' => false,
            'message' => 'Produto encontrado com sucesso',
            'product' => $product
        ]);
    }

    public function update(UpdateProductRequest $request, $productId)
    {
        $data = $request->validated();

        $product = $this->productService->update($data, $productId);

        return response()->json([
            'error' => false,
            'message' => 'Produto atualizado com sucesso',
            'product' => $product
        ]);
    }

    public function delete($productId)
    {
        $this->productService->delete($productId);

        return response()->json([
            'error' => false,
            'message' => 'Produto excluído com sucesso',
        ]);
    }
}
