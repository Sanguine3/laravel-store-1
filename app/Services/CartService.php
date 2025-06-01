<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class CartService
{
    protected const SESSION_KEY = 'cart';

    public function getContent(Request $request): array
    {
        return $request->session()->get(self::SESSION_KEY, []);
    }

    public function add(Request $request, Product $product, int $quantity = 1): void
    {
        $cart = $this->getContent($request);
        $id = (string) $product->id;
        $cart[$id] = ($cart[$id] ?? 0) + $quantity;
        $request->session()->put(self::SESSION_KEY, $cart);
    }

    public function update(Request $request, string $productId, int $quantity): void
    {
        $cart = $this->getContent($request);
        if (isset($cart[$productId])) {
            $cart[$productId] = $quantity;
            $request->session()->put(self::SESSION_KEY, $cart);
        }
    }

    public function remove(Request $request, string $productId): void
    {
        $cart = $this->getContent($request);
        unset($cart[$productId]);
        $request->session()->put(self::SESSION_KEY, $cart);
    }

    public function clear(Request $request): void
    {
        $request->session()->forget(self::SESSION_KEY);
    }
} 