<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderProcessingService
{
    
    private const DEFAULT_TAX_RATE = 0.08;

    /**
     * Create an order with items and calculate tax.
     * Uses a DB Transaction and Row Locking to ensure data integrity.
     *
     * @param array $data Expected keys: 'items', 'user_id' (optional), 'email'
     * @return Order
     * @throws Exception
     */
    public function createOrder(array $data): Order
    {
        
        return DB::transaction(function () use ($data) {
            $subtotal = 0;
            $orderItems = [];

            foreach ($data['items'] as $item) {
                //  SENIOR LEVEL: lockForUpdate() prevents race conditions during high traffic
                // This forces other transactions to wait if they try to buy the same product
                $product = Product::where('id', $item['id'])->lockForUpdate()->firstOrFail();

                $qty = $item['quantity'] ?? 1;

                if ($product->stock < $qty) {
                    throw new Exception("Product '{$product->name}' has insufficient stock.");
                }

              
                $product->decrement('stock', $qty);

              
                $subtotal += $product->price * $qty;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $product->price,
                ];
            }

            $tax = $subtotal * self::DEFAULT_TAX_RATE;
            $total = $subtotal + $tax;

           
            $order = Order::create([
                'user_id'      => $data['user_id'] ?? null,
                'email'        => $data['email'] ?? null,
                'total_amount' => $total, 
                'tax'          => $tax,
                'status'       => 'pending',
            ]);

           
            $order->items()->createMany($orderItems);

            Log::info("Order #{$order->id} created. Total: {$total}");

            return $order->load('items');
        });
    }

    /**
     * Calculate order summary (Helper for frontend display)
     */
    public function getOrderSummary(Order $order): array
    {
        $subtotal = $order->items->sum(fn($item) => $item->price * $item->quantity);
        $tax = $subtotal * self::DEFAULT_TAX_RATE;

        return [
            'subtotal' => $subtotal,
            'tax'      => $tax,
            'total'    => $subtotal + $tax,
        ];
    }
}