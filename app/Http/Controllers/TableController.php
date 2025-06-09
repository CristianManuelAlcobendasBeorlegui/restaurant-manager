<?php

namespace App\Http\Controllers;

use App\Models\ConnectedUser;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    function create(Request $request)
    {
        $table = Table::create([
            'status' => $request->input('status'),
            'max_guests' => $request->input('max_guests'),
            'guests' => $request->input('guests'),
            'connected_guests' => $request->input('connected_guests'),
            'code' => $request->input('code'),
            'data' => $request->input('data'),
            'handle' => $request->input('handle'),
        ]);

        // Crear automáticamente una order asociada a la mesa
        Order::create([
            'table_id' => $table->id,
            'status' => 'ordering',
            'observations' => null,
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'Table created',
        ]);
    }

    public function update(Request $request)
    {
        $table = Table::findOrFail($request->id);

        // Supón que $oldCode es el código actual y $newCode es el nuevo código
        $oldCode = $table->code;

        // Elimina usuarios conectados asociados al código antiguo
        ConnectedUser::where('table_code', $oldCode)->delete();

        // Elimina órdenes asociadas al código antiguo
        Order::whereHas('table', function ($query) use ($oldCode) {
            $query->where('code', $oldCode);
        })->delete();

        // Crear una nueva orden asociada a la mesa con status 'ordering'
        Order::create([
            'table_id' => $table->id,
            'status' => 'ordering',
            'observations' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update data
        $table->status = $request->input('status', $table->status);
        $table->max_guests = $request->input('max_guests', $table->max_guests);
        $table->guests = $request->input('guests', $table->guests);
        $table->code = $request->input('code', $table->code);
        $table->data = $request->input('data', json_encode($table->data));
        $table->handle = $request->input('handle', json_encode($table->handle));
        $table->save();

        return response()->json([
            'status' => 'ok',
            'message' => 'Table ' . $request->input('id') . ' updated',
        ]);
    }

    public function index()
    {
        $tables = Table::all();
        return response()->json([
            'status' => 'ok',
            'tables' => $tables,
        ]);
    }

    public function remove(Request $request)
    {
        $table = Table::findOrFail($request->id);
        $table->delete();

        return response()->json([
            'status' => 'ok',
            'message' => 'Table successfully deleted',
        ]);
    }
}
