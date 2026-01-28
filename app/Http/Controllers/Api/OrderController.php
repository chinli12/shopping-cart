<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderProcessingService;
use Illuminate\Http\JsonResponse;
use Exception;

class OrderController extends Controller
{
    public function __construct(
        protected OrderProcessingService $orderService
    ) {}

    /**
     * Create a new order with items and tax calculation.
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'id' => $order->id,
                    'total' => $order->total_amount,
                    'tax' => $order->tax,
                    'status' => $order->status,
                    'items' => $order->items->map(fn ($item) => [
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'subtotal' => $item->price * $item->quantity,
                    ]),
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     
     *
     * @param Order $order
     * @return JsonResponse
     */
    public function show(Order $order): JsonResponse
    {
        $summary = $this->orderService->getOrderSummary($order);

        return response()->json([
            'success' => true,
            'data' => [
                'order' => [
                    'id' => $order->id,
                    'status' => $order->status,
                    'created_at' => $order->created_at,
                ],
                'summary' => $summary
            ]
        ]);
    }

    /**
     * List all orders.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::with('items')->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}