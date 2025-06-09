<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        $category = Category::create([
            'name' => $request->input('name'),
            'description' => $request->input('description', ''),
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'Category created',
        ]);
    }

    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'status' => 'ok',
            'categories' => $categories,
        ]);
    }

    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);

        $category->name = $request->input('name', $category->name);
        $category->description = $request->input(
            'description',
            $category->description
        );

        $category->save();

        return response()->json([
            'status' => 'ok',
            'message' => 'Category updated',
        ]);
    }

    public function remove(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->delete();

        return response()->json([
            'status' => 'ok',
            'message' => 'Category deleted',
        ]);
    }
}
