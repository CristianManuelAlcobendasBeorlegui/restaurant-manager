<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function addItemToOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'item_id' => 'required|integer|exists:items,id',
                'quantity' => 'required|integer|min:1',
                'connected_user_code' =>
                    'nullable|string|exists:connected_users,code',
                'status' => 'nullable|string',
            ]);

            $orderItems = [];
            for ($i = 0; $i < $validated['quantity']; $i++) {
                $orderItems[] = OrderItem::create([
                    'order_id' => $validated['order_id'],
                    'item_id' => $validated['item_id'],
                    'connected_user_code' =>
                        $validated['connected_user_code'] ?? null,
                    'status' => $validated['status'] ?? 'ordering',
                ]);
            }

            return response()->json(
                [
                    'status' => 'ok',
                    'message' => 'Item added',
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    public function getCurrentTableOrder(Request $request)
    {
        try {
            $request->validate([
                'table_code' => 'required|string|exists:tables,code',
            ]);

            // Buscar la mesa por el código
            $table = Table::where('code', $request->table_code)->first();

            if (!$table) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Mesa no encontrada',
                    ],
                    404
                );
            }

            // Buscar la orden con status 'ordering' para esa mesa
            $order = Order::where('table_id', $table->id)
                ->where('status', 'ordering')
                ->latest()
                ->first();

            if (!$order) {
                return response()->json([
                    'status' => 'ok',
                    'table' => $table->id,
                    'order' => [
                        'id' => null,
                        'items' => [],
                    ],
                ]);
            }

            // Agrupar los order_items por item_id y contar la cantidad
            $items = OrderItem::where('order_id', $order->id)
                ->with('item')
                ->selectRaw('item_id, COUNT(*) as quantity')
                ->groupBy('item_id')
                ->get()
                ->map(function ($orderItem) {
                    return [
                        'id' => $orderItem->item_id,
                        'name' => $orderItem->item->name ?? null,
                        'quantity' => (int) $orderItem->quantity,
                        'supplement_price' =>
                            (float) ($orderItem->item->supplement_price ?? 0.0),
                    ];
                });

            return response()->json([
                'status' => 'ok',
                'table' => $table->id,
                'order' => [
                    'id' => $order->id,
                    'items' => $items,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error inesperado: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    public function requestOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'user_code' => 'required|string|exists:connected_users,code',
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|integer|exists:items,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.status' => 'nullable|string',
            ]);

            // Buscar la orden
            $order = Order::find($validated['order_id']);
            if (!$order) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Orden not found',
                    ],
                    404
                );
            }

            // Eliminar todos los order_items asociados a la orden
            OrderItem::where('order_id', $order->id)->delete();

            // Añadir los nuevos items usando user_code para todos
            $newOrderItems = [];
            foreach ($validated['items'] as $itemData) {
                for ($i = 0; $i < $itemData['quantity']; $i++) {
                    $newOrderItems[] = OrderItem::create([
                        'order_id' => $order->id,
                        'item_id' => $itemData['id'],
                        'connected_user_code' => null,
                        'status' =>
                            $itemData['status'] ?? 'waiting-for-validation',
                    ]);
                }
            }

            // Cambiar el status de la order
            $order->status = 'waiting-for-validation';
            $order->created_at = now();
            $order->save();

            // Crear una nueva orden con status 'ordering' asociada a la misma mesa
            $newOrder = Order::create([
                'table_id' => $order->table_id,
                'status' => 'ordering',
                'observations' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'ok',
                'message' => 'Your order has been requested',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    public function acceptOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'user_code' => 'nullable|string|exists:connected_users,code',
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|integer|exists:items,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.status' => 'nullable|string',
            ]);

            // Buscar la orden original
            $order = Order::find($validated['order_id']);
            if (!$order) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Orden not found',
                    ],
                    404
                );
            }

            // Eliminar todos los order_items asociados a la orden original
            OrderItem::where('order_id', $order->id)->delete();

            // Añadir los nuevos items usando user_code para todos
            $newOrderItems = [];
            foreach ($validated['items'] as $itemData) {
                for ($i = 0; $i < $itemData['quantity']; $i++) {
                    $newOrderItems[] = OrderItem::create([
                        'order_id' => $order->id,
                        'item_id' => $itemData['id'],
                        'connected_user_code' => $validated['user_code'],
                        'status' => $itemData['status'] ?? 'in-queue',
                    ]);
                }
            }

            // Cambiar el status de la order
            $order->status = 'in-queue';
            $order->save();

            return response()->json([
                'status' => 'ok',
                'message' =>
                    'Order successfully accepted',
                'order_items' => $newOrderItems,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error inesperado: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    public function deleteItem(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'item_id' => 'required|integer|exists:items,id',
            ]);

            // Eliminar todos los order_items asociados a ese item_id y order_id
            $deleted = OrderItem::where('order_id', $validated['order_id'])
                ->where('item_id', $validated['item_id'])
                ->delete();

            return response()->json([
                'status' => 'ok',
                'deleted_count' => $deleted,
                'message' => 'Item successfully deleted',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    public function denyOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'user_code' => 'nullable|string|exists:connected_users,code',
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|integer|exists:items,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.status' => 'nullable|string',
                'observations' => 'nullable|string',
            ]);

            // Buscar la orden original
            $order = Order::find($validated['order_id']);
            if (!$order) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Orden not found',
                    ],
                    404
                );
            }

            // Eliminar todos los order_items asociados a la orden original
            OrderItem::where('order_id', $order->id)->delete();

            // Añadir los nuevos items usando user_code para todos (puede ser null)
            $newOrderItems = [];
            foreach ($validated['items'] as $itemData) {
                for ($i = 0; $i < $itemData['quantity']; $i++) {
                    $newOrderItems[] = OrderItem::create([
                        'order_id' => $order->id,
                        'item_id' => $itemData['id'],
                        'connected_user_code' =>
                            $validated['user_code'] ?? null,
                        'status' => $itemData['status'] ?? 'denied',
                    ]);
                }
            }

            // Cambiar el status de la order y guardar las observaciones
            $order->status = 'denied';
            $order->observations = $validated['observations'] ?? null;
            $order->save();

            return response()->json([
                'status' => 'ok',
                'message' =>
                    'Order denied successfully',
                'order_items' => $newOrderItems,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    // public function index(Request $request)
    // {
    //     try {
    //         // Recuperar todas las órdenes que NO tengan status 'ordering'
    //         $orders = Order::with('table')
    //             ->where('status', '!=', 'ordering')
    //             ->get();

    //         $result = $orders->map(function ($order) {
    //             // Agrupar los order_items por item_id y contar la cantidad
    //             $items = OrderItem::where('order_id', $order->id)
    //                 ->with('item')
    //                 ->selectRaw('item_id, COUNT(*) as quantity')
    //                 ->groupBy('item_id')
    //                 ->get()
    //                 ->map(function ($orderItem) {
    //                     return [
    //                         'id' => $orderItem->item_id,
    //                         'name' => $orderItem->item->name ?? null,
    //                         'quantity' => (int) $orderItem->quantity,
    //                         'supplement_price' =>
    //                             (float) ($orderItem->item->supplement_price ??
    //                                 0.0),
    //                     ];
    //                 });

    //             return [
    //                 'id' => $order->id,
    //                 'table' => $order->table_id,
    //                 'guests' => $order->table->guests ?? null,
    //                 'status' => $order->status,
    //                 'updated_at' => $order->updated_at,
    //                 'items' => $items,
    //             ];
    //         });

    //         return response()->json([
    //             'status' => 'ok',
    //             'orders' => $result,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json(
    //             [
    //                 'status' => 'error',
    //                 'message' => 'Error: ' . $e->getMessage(),
    //             ],
    //             500
    //         );
    //     }
    // }

    public function index(Request $request)
    {
        try {
            // Recuperar todas las órdenes que NO tengan status 'ordering'
            $orders = Order::with('table')
                ->where('status', '!=', 'ordering')
                ->get();

            $result = $orders->map(function ($order) {
                // Agrupar los order_items por item_id y contar la cantidad
                $groupedItems = OrderItem::where('order_id', $order->id)
                    ->with('item')
                    ->get()
                    ->groupBy('item_id');

                $items = $groupedItems
                    ->map(function ($orderItems, $itemId) {
                        $firstOrderItem = $orderItems->first();
                        return [
                            'id' => $itemId,
                            'name' => $firstOrderItem->item->name ?? null,
                            'quantity' => $orderItems->count(),
                            'has_supplement' =>
                                (bool) ($firstOrderItem->item->has_supplement ??
                                    false),
                            'supplement_price' =>
                                (float) ($firstOrderItem->item
                                    ->supplement_price ?? 0.0),
                            'subitems' => $orderItems
                                ->map(function ($subitem) {
                                    return [
                                        'id' => $subitem->id,
                                        'status' => $subitem->status,
                                    ];
                                })
                                ->values(),
                        ];
                    })
                    ->values();

                // Formatear el timestamp updated_at
                $createdAtFormatted = $order->updated_at
                    ? $order->created_at->format('d/m/Y H:i')
                    : null;
                $updatedAtFormatted = $order->updated_at
                    ? $order->updated_at->format('d/m/Y H:i')
                    : null;

                return [
                    'id' => $order->id,
                    'table' => $order->table_id,
                    'guests' => $order->table->guests ?? null,
                    'status' => $order->status,
                    'created_at' => $createdAtFormatted,
                    'updated_at' => $updatedAtFormatted,
                    'items' => $items,
                ];
            });

            return response()->json([
                'status' => 'ok',
                'orders' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    public function indexByTableCode(Request $request)
    {
        try {
            $request->validate([
                'table_code' => 'required|string|exists:tables,code',
            ]);

            // Buscar la mesa por el código
            $table = Table::where('code', $request->table_code)->first();

            if (!$table) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Table not found',
                    ],
                    404
                );
            }

            // Recuperar las órdenes de la mesa indicada que NO tengan status 'ordering'
            $orders = Order::with('table')
                ->where('table_id', $table->id)
                ->where('status', '!=', 'ordering')
                ->get();

            $result = $orders->map(function ($order) {
                // Agrupar los order_items por item_id y contar la cantidad
                $groupedItems = OrderItem::where('order_id', $order->id)
                    ->with('item')
                    ->get()
                    ->groupBy('item_id');

                $items = $groupedItems
                    ->map(function ($orderItems, $itemId) {
                        $firstOrderItem = $orderItems->first();
                        return [
                            'id' => $itemId,
                            'name' => $firstOrderItem->item->name ?? null,
                            'quantity' => $orderItems->count(),
                            'has_supplement' =>
                                (bool) ($firstOrderItem->item->has_supplement ??
                                    false),
                            'supplement_price' =>
                                (float) ($firstOrderItem->item
                                    ->supplement_price ?? 0.0),
                            'subitems' => $orderItems
                                ->map(function ($subitem) {
                                    return [
                                        'id' => $subitem->id,
                                        'status' => $subitem->status,
                                    ];
                                })
                                ->values(),
                        ];
                    })
                    ->values();

                // Formatear el timestamp updated_at
                $updatedAtFormatted = $order->updated_at
                    ? $order->updated_at->format('d/m/Y H:i')
                    : null;

                return [
                    'id' => $order->id,
                    'table' => $order->table_id,
                    'guests' => $order->table->guests ?? null,
                    'status' => $order->status,
                    'updated_at' => $updatedAtFormatted,
                    'items' => $items,
                ];
            });

            return response()->json([
                'status' => 'ok',
                'orders' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage(),
                ],
                500
            );
        }
    }

    public function updateOrderItemsStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|integer|exists:orders,id',
                'status' => 'required|string',
                'subitem' => 'required|array',
                'subitem.id' => 'required|integer|exists:order_items,id',
                'subitem.status' => 'required|string',
            ]);

            // Buscar el order_item correspondiente
            $orderItem = OrderItem::where('order_id', $validated['order_id'])
                ->where('id', $validated['subitem']['id'])
                ->first();

            if (!$orderItem) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Order item not found',
                    ],
                    404
                );
            }

            // Actualizar el status del order_item
            $orderItem->status = $validated['subitem']['status'];
            $orderItem->save();

            // Buscar y actualizar el status del order asociado
            $order = Order::find($validated['order_id']);
            if ($order) {
                $order->status = $validated['status'];
                $order->save();
            }

            return response()->json([
                'status' => 'ok',
                'message' => 'Item status updated',
                'order_item' => $orderItem,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Error: ' . $e->getMessage(),
                ],
                500
            );
        }
    }
}
