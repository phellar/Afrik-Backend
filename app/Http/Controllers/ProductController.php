<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display all products.
     */

     public function __construct()
     {
        
     }

     
    public function index()
    {
        
    }

    /**
     * create a new product and save to database.
     */

    public function store(Request $request)
    {
        // Sanitize input
        $sanitizedInput = [
            'product_name' => trim(strip_tags($request->product_name)),
            'product_desc' => trim(strip_tags($request->product_desc)),
            'price'        => floatval($request->price),
            'category'     => trim(strip_tags($request->category)),
        ];
    
        // Validate input
        $validated = validator($sanitizedInput, [
            'product_name' => 'required|string|max:255',
            'product_desc' => 'nullable|string|max:255',
            'price'        => 'required|numeric|min:0',
            'category'     => 'required|string|max:255',
        ])->validate();
    

        // Handle file upload
        $image_path = null;

        if ($request->hasFile('product_image')) {
            $request->validate([
                'product_image' => 'required|image|mimes:jpeg,png,jpg|max:15360',
            ]);
            $image_path = $request->file('product_image')->store('products', 'public');
        }
    
        // Create and save product using the sanitized and validated input
        $product = Product::create([
            'product_name'  => $validated['product_name'],
            'product_desc'  => $validated['product_desc'],
            'product_image' => $image_path,
            'price'         => $validated['price'],
            'category'      => $validated['category'],
        ]);
    
        // Return response
        return response()->json([
            'message' => 'Product Created Successfully',
            'data' => new ProductResource($product),
        ], 201);
    }
    

    /**
     * Display the specific product by id.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
