<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CartItemRequest;

class CartController extends Controller
{
    private CartService $service;

    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): \Inertia\Response
    {
        $cart = $this->service->getContent($request);
        $products = Product::findMany(array_keys($cart));
        return Inertia::render('Customer/Cart/Index', ['cart' => $cart, 'products' => $products]);
    }

    public function add(CartItemRequest $request, Product $product): RedirectResponse
    {
        $this->service->add($request, $product, $request->validated()['quantity']);
        return redirect()->route('cart.view');
    }

    public function update(CartItemRequest $request, string $productId): RedirectResponse
    {
        $this->service->update($request, $productId, $request->validated()['quantity']);
        return redirect()->route('cart.view');
    }

    public function remove(Request $request, string $productId): RedirectResponse
    {
        $this->service->remove($request, $productId);
        return redirect()->route('cart.view');
    }
} 