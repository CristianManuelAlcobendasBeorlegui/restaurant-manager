<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'table',
            'orderItems' => function ($query) {
                $query->whereNull('parent_id')->with(['item', 'subitems']);
            },
        ])->get();

        $result = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'table' => $order->table_id,
                'guests' => $order->table->guests ?? null,
                'status' => [
                    'codename' => $order->status,
                    'label' => str_replace('-', ' ', $order->status),
                ],
                'items' => $order->orderItems->map(function ($orderItem) {
                    return [
                        'id' => $orderItem->id,
                        'name' => $orderItem->item->name ?? null,
                        'quantity' => $orderItem->quantity,
                        'has_supplement' => $orderItem->has_supplement,
                        'supplement_price' => $orderItem->supplement_price,
                        'subitems' => $orderItem->subitems->map(function (
                            $subitem
                        ) {
                            return [
                                'id' => $subitem->id,
                                'status' => $subitem->status,
                            ];
                        }),
                    ];
                }),
                'observations' => $order->observations,
                'added_at' => optional($order->added_at)->format('d/m/Y H:i\h'),
                'modified_at' => optional($order->modified_at)->format(
                    'd/m/Y H:i\h'
                ),
            ];
        });

        return response()->json([
            'status' => 'ok',
            'orders' => $result,
        ]);
    }
}
