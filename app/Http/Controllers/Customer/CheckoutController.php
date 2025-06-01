<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CustomerOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use App\Http\Requests\ProcessCheckoutRequest;

class CheckoutController extends Controller
{
    private CartService $cartService;
    private CustomerOrderService $orderService;

    public function __construct(CartService $cartService, CustomerOrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function show(Request $request): \Inertia\Response
    {
        $cart = $this->cartService->getContent($request);
        return Inertia::render('Customer/Checkout/Show', ['cart' => $cart]);
    }

    public function process(ProcessCheckoutRequest $request): RedirectResponse
    {
        // Business logic to create order from cart should be in a service
        // For now, clear cart and redirect to orders
        $this->cartService->clear($request);
        return redirect()->route('orders.index')->with('success', 'Order placed.');
    }
} 