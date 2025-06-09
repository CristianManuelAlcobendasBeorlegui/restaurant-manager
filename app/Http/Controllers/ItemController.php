<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function create(Request $request)
    {
        $item = Item::create([
            'name' => $request->input('name'),
            'image' => $request->input('image'), // Asegúrate de manejar el blob correctamente si es necesario
            'quantity_type' => $request->input('quantity_type'),
            'items_per_unit' => $request->input('items_per_unit'),
            'category_id' => $request->input('category')['id'],
            'description' => $request->input('description', ''),
            'allergens' => $request->input('allergens', []),
            'has_supplement' => $request->input('has_supplement', false),
            'supplement_price' => $request->input('supplement_price', 0.0),
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'Item created',
        ]);
    }

    public function index()
    {
        $items = Item::with('category')->get();
        return response()->json([
            'status' => 'ok',
            'items' => $items,
        ]);
    }

    public function update(Request $request)
    {
        $item = Item::findOrFail($request->id);

        $item->name = $request->input('name', $item->name);
        $item->image = $request->input('image') ?? $item->image;
        $item->quantity_type = $request->input(
            'quantity_type',
            $item->quantity_type
        );
        $item->items_per_unit = $request->input(
            'items_per_unit',
            $item->items_per_unit
        );
        $item->category_id = $request->input('category')['id'];
        $item->description = $request->input('description', $item->description);
        $item->allergens = $request->input('allergens', $item->allergens);
        $item->has_supplement = $request->input(
            'has_supplement',
            $item->has_supplement
        );
        $item->supplement_price = $request->input(
            'supplement_price',
            $item->supplement_price
        );

        $item->save();

        return response()->json([
            'status' => 'ok',
            'message' => 'Item updated',
        ]);
    }

    public function remove(Request $request)
    {
        $item = Item::findOrFail($request->id);
        $item->delete();

        return response()->json([
            'status' => 'ok',
            'message' => 'Item deleted',
        ]);
    }
}
