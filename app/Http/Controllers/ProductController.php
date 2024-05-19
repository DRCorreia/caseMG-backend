<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $products = Product::with("stock")
            ->where("user_id", $userId)->get();

        //longa escala posso trocar para esse:
        // $products = Product::where('user_id', $userId)->paginate(10);

        // Converter imagens para base64
        $products->transform(function ($product) {
            if ($product->image) {
                $product->image = base64_encode($product->image);
            }
            return $product;
        });

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $userId = Auth::id();
        $image = null;

        if ($request->hasFile('image')) {
            $image = file_get_contents($request->file('image')->path());
        }

        $product = Product::create([
            'user_id' => $userId,
            'name' => $request->name,
            'description' => $request->description,
            'value' => $request->value,
            'image' => $image,
        ]);

        $stock = Stock::create([
            'product_id' => $product->id,
            'qty' => $request->stock,
        ]);

        $movement = Movement::create([
            'product_id' => $product->id,
            'movement_type' => 'E',
            'movement_qty' => $request->stock
        ]);

        $productArray = $product->toArray();
        if ($product->image) {
            $productArray['image'] = base64_encode($product->image);
        }

        return response()->json($productArray, 201);
    }

    public function show($id)
    {
        $userId = Auth::id();

        $product = Product::where('id'->$id)
            ->where("user_id", $userId)->get();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $productArray = $product->toArray();
        if ($product->image) {
            $productArray['image'] = base64_encode($product->image);
        }

        return response()->json($productArray);
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();

        $product = Product::with('stock')
            ->where('id', $id)
            ->where('user_id', $userId)->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'name' => 'string|max:255',
            'value' => 'numeric',
            'description' => 'nullable|string',
            'stock' => 'required|numeric',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $image = $product->image;
        if ($request->hasFile('image')) {
            $image = file_get_contents($request->file('image')->path());
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'value' => $request->value,
            'image' => $image,
        ]);

        if ($request->stock != $product->stock['qty']) {
            $qtdMovement = 0;
            $movementType = 'E';
            if ($request->stock < $product->stock['qty']) {
                $movementType = 'S';
                $qtdMovement = $product->stock['qty'] - $request->stock;
            } else {
                $qtdMovement = $request->stock - $product->stock['qty'];
            }

            $movement = Movement::create([
                'product_id' => $product->id,
                'movement_type' => $movementType,
                'movement_qty' => $qtdMovement,
            ]);

            $product->stock['qty'] = $request->stock;
            $product->stock->save();
        }
        $productArray = $product->toArray();
        if ($product->image) {
            $productArray['image'] = base64_encode($product->image);
        }

        return response()->json($productArray);
    }

    public function destroy($id)
    {
        $userId = Auth::id();

        $product = Product::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Remover estoque associado
        Stock::where('product_id', $id)->delete();

        // Remover movimentos associados
        Movement::where('product_id', $id)->delete();

        // Remover produto
        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }

}
