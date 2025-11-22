<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();

        if($orders->count() < 0 ){
            return response()->json([
                'message' => 'No Orders Found'
            ], 200);
        }

        else{
            return response()->json([
                'message' => 'Orders Retrieved SuccessFully',
                'data' => new OrderResource($orders)
            ], 200);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'address' => 'required|string|min:1',
            'total' => 'required|numeric|min:1',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:1',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'invalid order data',
                'error'=>$validator->errors()
            ],422);
        }

        $order = Order::create([
            'Ref' => 'ORD' . Strtoupper(Str::random(10)),
            'customer_name'=>$request->customer_name,
            'customer_phone'=>$request->customer_phone,
            'customer_email'=>$request->customer_email,
            'address'=>$request->address,
            'total'=>$request->total,
        ]);
        
        // save order
        $order->items()->createMany($request->items);

        // send order notification email to customer
        Mail::to($order->customer_email)
             ->send(new OrderConfirmationMail($order, 'customer'));

        // Send order Notification email to vendor
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)
                ->send(new OrderConfirmationMail($order, 'vendor'));
        }

        return response()->json([
            'message'=>'Order saved successfully',
            'data' => $order->load('items'),

            ],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
    }
}
