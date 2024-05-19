<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//cadastro
Route::post('/register', [UserController::class, 'register']);

//login
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {

    //logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // #Produtos
    //listar - já retorna com o estoque
    Route::get('/products', [ProductController::class, 'index']);

    //buscar por id
    Route::get('/products/{id}', [ProductController::class, 'show']);

    //criar
    Route::post('/products/new', [ProductController::class, 'store']);

    //editar
    Route::post('/products/{id}', [ProductController::class, 'update']);

    //remover
    Route::delete('/products/delete/{id}', [ProductController::class,'destroy']);

    //#Movimentos
    Route::get('/movements/{product_id}', [MovementController::class, 'show']);
    Route::post('/movements/simulate', [MovementController::class, 'simulateMovement']);

});
