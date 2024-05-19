<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovementController extends Controller
{
    public function show($product_id)
    {
        $userId = Auth::id();

        //Validando se o usuário está acessando uma mov. dele mesmo
        $product = Product::with('stock')
            ->where('id', $product_id)
            ->where('user_id', $userId)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found or you do not have access to this product'], 404);
        }

        $movements = Movement::where('product_id', $product->id)->get();

        //por conta do blob
        $productArray = $product->toArray();
        if ($product->image) {
            $productArray['image'] = base64_encode($product->image);
        }

        if (!$movements) {
            return response()->json(['message' => 'Movements not found'], 404);
        }
        return response()->json(['movements' => $movements, 'product' => $productArray], 200);
    }

    public function simulateMovement(Request $request)
    {
        info($request);
        $request->validate([
            'productId' => 'required|numeric',
            'movementType' => 'required|string|max:2',
            'movementQty' => 'required|numeric'
        ]);

        $userId = Auth::id();
        $productId = $request->input('productId');
        $movementType = $request->input('movementType');
        $movementQty = $request->input('movementQty');

        $product = Product::with('stock')
            ->where('id', $productId)
            ->where('user_id', $userId)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found or you do not have access to this product'], 404);
        }

        switch ($movementType) {
            case 'E':
                $product->stock['qty'] +=  $movementQty;
                break;
            case 'S':
                $product->stock['qty'] -=  $movementQty;
                break;
        }
        $product->stock->save();

        $movement = Movement::create([
            'product_id' => $productId,
            'movement_type' => $movementType,
            'movement_qty' => $movementQty,
        ]);

        return response()->json(['message' => 'Stock movement simulated successfully'], 200);
    }
}
