<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConnectedUserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\TableController;
use Illuminate\Contracts\Redis\Connector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Table
Route::post('/create-table', [TableController::class, 'create']);
Route::post('/update-table', [TableController::class, 'update']);
Route::post('/remove-table', [TableController::class, 'remove']);
Route::get('/tables', [TableController::class, 'index']);

// Category
Route::post('/create-category', [CategoryController::class, 'create']);
Route::post('/update-category', [CategoryController::class, 'update']);
Route::post('/remove-category', [CategoryController::class, 'remove']);
Route::get('/categories', [CategoryController::class, 'index']);

// Item
Route::post('/create-item', [ItemController::class, 'create']);
Route::post('/update-item', [ItemController::class, 'update']);
Route::post('remove-item', [ItemController::class, 'remove']);
Route::get('/items', [ItemController::class, 'index']);

// Orders
Route::post('/current-order', [
    OrderItemController::class,
    'getCurrentTableOrder',
]);
Route::post('/add-item-to-order', [
    OrderItemController::class,
    'addItemToOrder',
]);
Route::post('/request-order', [OrderItemController::class, 'requestOrder']);
Route::post('/accept-order', [OrderItemController::class, 'acceptOrder']);
Route::post('/deny-order', [OrderItemController::class, 'denyOrder']);
Route::post('/delete-item', [OrderItemController::class, 'deleteItem']);
Route::post('update-order-item-status', [
    OrderItemController::class,
    'updateOrderItemsStatus',
]);
Route::post('/table-orders', [OrderItemController::class, 'indexByTableCode']);
Route::get('/orders', [OrderItemController::class, 'index']);

// Connected users
Route::post('/join-table', [ConnectedUserController::class, 'joinTable']);
Route::post('/leave-table', [ConnectedUserController::class, 'leaveTable']);
Route::post('/connected-users', [
    ConnectedUserController::class,
    'getTableConnectedUsers',
]);
Route::post('/user-healthcheck', [
    ConnectedUserController::class,
    'userHealthcheck',
]);
