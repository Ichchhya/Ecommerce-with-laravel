<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order_id = session('order_id',0);
        // this can be done if we want to add the default shipping address of the user as his/her permanent address
        // $user = Auth::user();
        // $user->address;

        //checking if there is valid order_id in the session
        if($order_id < 1){
            // creating order if there is no order_id in the session
            $order = new Order();
            $order->user_id = Auth::id();
            $order->order_status ='cart';
            $order->sub_total=0;
            $order->discount = 0;
            $order-> shipping_price = 100;
            $order->total_price = 0;
            $order-> shipping_address =' ';
            $order->save();
            session(['order_id' => $order->id]);
            $order_id= $order->id;

        }
        //adding items to card i.e. creating order_item
        $order_item = new OrderItem();
        $order_item->order_id = $order_id;
        $order_item-> product_id = $request->input('product_id');
        $product = Product::find($order_item->product_id);
        $order_item-> product_price = $product->price;
        $order_item-> quantity= $request->input('quantity');
        $order_item-> total = $order_item-> quantity * $order_item-> product_price;
        $order_item->save();
        $order = Order::find($order_id);
        $order->sub_total += $order_item->total;
        $order->total_price = $order->sub_total + $order->discount + $order->shipping_price;
        $order->save();
        return redirect( route('order.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderItem  $orderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderItem = OrderItem::find($id);
        return $orderItem->order;
        $orderItem->order->sub_total -= $orderItem->total;
        $orderItem->order->total_price = $orderItem->order->sub_total + $orderItem->order->shipping_price + $orderItem->order->total;
        $orderItem->order->save();
        $orderItem->delete();
        return redirect()->route('order.index');
    }
}
