<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CustomerOrderService;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    private CustomerOrderService $service;

    public function __construct(CustomerOrderService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
    {
        $orders = $this->service->getUserOrders();
        return Inertia::render('Customer/Orders/Index', ['orders' => $orders]);
    }

    public function show($id): Response
    {
        $order = $this->service->getUserOrder($id);
        return Inertia::render('Customer/Orders/Show', ['order' => $order]);
    }
}
