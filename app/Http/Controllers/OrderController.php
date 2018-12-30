<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Order;
use App\OrderProduct;
use App\User;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $carts = Cart::where('user_id', Auth::user()->id)->get()->load('product');
        if (sizeOf($carts) == 0){
            return redirect()->route('cart.index');
        };
        $order = Order::where('status','PENDING')->get();
        if ($order){
            $unique_id = $order->last()->unique_id+1%1000;
        } else {
            $unique_id = 1;
        }
        return view('orders.create')->with(compact('carts','unique_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request['user'])->load('carts', 'carts.product');
        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'PENDING',
            'address' => $request['address'],
            'unique_id' => $request['unique_id'],
            'shipping_fee' => 5000
        ]);
        $total_price = 0;
        $total_weight = 0;
        foreach ($user->carts as $cart){
            $op = OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'sum_price' => $cart->product->price * $cart->quantity,
                'sum_weight' => $cart->product->weight * $cart->quantity
            ]);
            $total_price += $cart->product->price * $cart->quantity;
            $total_weight += $cart->product->weight * $cart->quantity;
            $order->order_products()->save($op);
        }

        $fee = round($total_weight) * 5000;
        if ($fee > $order->shipping_fee){
            $order->update(['shipping_fee' => $fee]);
        }
        $order->update([
            'sum_price' => $total_price,
            'sum_weight' => $total_weight,
            'amount' => $total_price + $order->shipping_fee - $order->unique_id
        ]);

        $user->carts()->delete();
        return redirect()->route('orders.show',$order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
