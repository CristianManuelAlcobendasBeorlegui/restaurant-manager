<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Table;
use App\Models\ConnectedUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ConnectedUserController extends Controller
{
    public function joinTable(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|exists:tables,code',
            ]);

            // Buscar la mesa por el código
            $table = Table::where('code', $request->code)->firstOrFail();

            // Contar usuarios conectados a la mesa
            $connectedCount = ConnectedUser::where(
                'table_code',
                $table->code
            )->count();

            // Comprobar si se excede el número de invitados permitidos
            if ($connectedCount >= $table->guests) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' =>
                            'Table reached maximum number of connected users',
                    ],
                    403
                );
            }

            // Comprobar si ya hay un admin en la mesa
            $adminExists = ConnectedUser::where('table_code', $table->code)
                ->where('is_admin', true)
                ->exists();

            // Crear usuario conectado
            $userCode = Str::uuid()->toString();
            $userName = 'User' . rand(1000, 9999);

            $connectedUser = ConnectedUser::create([
                'code' => $userCode,
                'name' => $userName,
                'table_code' => $table->code,
                'is_admin' => !$adminExists,
            ]);

            // Cambiar el estado de la mesa a 'busy'
            $table->status = 'busy';
            $table->save();

            return response()->json([
                'status' => 'ok',
                'table_code' => $table->code,
                'table_id' => $table->id,
                'user_data' => [
                    'user_id' => $connectedUser->code,
                    'name' => $connectedUser->name,
                    'is_admin' => $connectedUser->is_admin,
                ],
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'status' => 'ok',
                    'message' => 'Table code does not exists',
                ],
                404
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

    public function leaveTable(Request $request)
    {
        try {
            Log::info('Petición sendBeacon recibida', $request->all());
            // Decodifica el contenido recibido (body plano)
            $data = json_decode($request->getContent(), true);

            // Valida el array manualmente
            $validated = validator($data, [
                'user_id' => 'required|string|exists:connected_users,code',
                'table_code' => 'required|string|exists:tables,code',
            ])->validate();

            // Buscar el usuario conectado
            $user = ConnectedUser::where('code', $validated['user_id'])
                ->where('table_code', $validated['table_code'])
                ->first();

            if (!$user) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'User not found',
                    ],
                    404
                );
            }

            $wasAdmin = $user->is_admin;

            // Eliminar el usuario
            $user->delete();

            // Buscar usuarios restantes en la mesa
            $remainingUsers = ConnectedUser::where(
                'table_code',
                $validated['table_code']
            )->get();

            // Si no quedan usuarios, poner la mesa como available
            $table = Table::where('code', $validated['table_code'])->first();
            if ($remainingUsers->isEmpty()) {
                if ($table) {
                    $table->status = 'available';
                    $table->save();
                }
            } elseif ($wasAdmin) {
                // Si el que se va era admin, el siguiente usuario pasa a ser admin
                $nextUser = $remainingUsers->first();
                if ($nextUser) {
                    $nextUser->is_admin = true;
                    $nextUser->save();
                }
            }

            return response()->json([
                'status' => 'ok',
                'message' => 'User disconnected',
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

    public function getTableConnectedUsers(Request $request)
    {
        try {
            $request->validate([
                'table_code' => 'required|string|exists:tables,code',
            ]);

            $users = ConnectedUser::where(
                'table_code',
                $request->table_code
            )->get();

            return response()->json([
                'status' => 'ok',
                'connected_users' => $users,
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

    public function userHealthcheck(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|exists:connected_users,code',
            ]);

            $user = ConnectedUser::where('code', $request->code)->first();

            if (!$user) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'User not found',
                    ],
                    404
                );
            }

            return response()->json([
                'status' => 'ok',
                'user_data' => [
                    'user_id' => $user->code,
                    'name' => $user->name,
                    'is_admin' => $user->is_admin,
                ],
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
