<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GroqController extends Controller
{
    public function askGroq(Request $request)
    {
        $validated = $request->validate([
            'prompt' => 'required|string'
        ]);

        $prompt = $validated['prompt'];

        $products = Product::all(['name', 'price', 'color', 'description'])->toArray();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',
            'stream' => false,
            "max_completion_tokens" => 1024,
            "top_p" => 1,
            "stop" => null,
            'temperature' => 0.5,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Você é um assistente que responde perguntas com base em uma lista de produtos.'
                ],
                [
                    'role' => 'user',
                    'content' => 'Lista de produtos: ' . json_encode($products)
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ]
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => true,
                'status' => $response->status(),
                'body' => $response->body()
            ], $response->status());
        }

        $conteudo = $response->json()['choices'][0]['message']['content'];

        return response()->json(['resposta' => $conteudo]);
    }
}
