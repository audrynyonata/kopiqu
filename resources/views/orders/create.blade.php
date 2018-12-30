@extends('layouts.app')

@section('header')
<style>
.img-responsive {
  width:100%;
  height: auto;
  margin: 0 auto;
}

.product-name{
  line-height:1.2em;
  height:1.2em;
  overflow: hidden;
}

.red {
  color:#d43f3a;
}

</style>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-xs-8 col-lg-8 col-xs-offset-2 col-lg-offset-2">
      <div class="box">
        <hr>
        <h2 class="intro-text text-center product-name">Checkout</h2>
        <hr>
        @php($subtotal_price = 0)
        @php($subtotal_weight = 0)
        @foreach($carts as $cart)
             @php($subtotal_price += $cart->quantity * $cart->product->price )
             @php($subtotal_weight += $cart->quantity * $cart->product->weight )
        @endforeach
        ORDER
        <br>
        <div class="col-xs-6 col-lg-6">
        SUBTOTAL
        </div>
        <div class="col-xs-6 col-lg-6" style="text-align: right">
        Rp{{ $subtotal_price }}
        </div>
        <div class="col-xs-6 col-lg-6">
        WEIGHT
        </div>
        <div class="col-xs-6 col-lg-6" style="text-align: right">
        {{ $subtotal_weight }} kg 
        </div>
        SHIPPING
        <br>
        <div class="col-xs-6 col-lg-6">
        RATE (Rp5000/kg) 
        </div>
        <div class="col-xs-6 col-lg-6" style="text-align: right">
        ({{ (round($subtotal_weight)*5000 > 5000) ? '~'.round($subtotal_weight) : 1}} kg x Rp5000)
        </div>
        <div class="col-xs-6 col-lg-6">
        FEE
        </div>
        <div class="col-xs-6 col-lg-6" style="text-align: right">
        Rp{{ round($subtotal_weight)*5000 ? round($subtotal_weight)*5000 : 5000}}
        </div>
        <div class="col-xs-12 col-lg-12">
          <br>
        </div>
        <div class="col-xs-6 col-lg-6">
         UNIQUE IDENTIFIER
        </div>
        <div class="col-xs-6 col-lg-6" style="text-align: right">
         {{ $unique_id }}
        </div>
        <div class="col-xs-12 col-lg-12" style="text-align: right">
          <hr>
          <small>TOTAL</small>
          <h3 class="red">Rp {{ $subtotal_price-$unique_id }}</h3>                
        </div>
      </div>
    </div>
    <div class="col-xs-8 col-lg-8 col-xs-offset-2 col-lg-offset-2">
      <div class="box">
        <p>Please pay the exact emount above.</p>
        We accept payment through methods below:
        <ul>
          <li>BCA : 123 456 7890</li>
          <li>BNI : 1545456 7890</li>
        </ul>
      </div>
    </div>
    <div class="col-xs-8 col-lg-8 col-xs-offset-2 col-lg-offset-2">
      <div class="box">
          <form method="POST" action="{{ route('orders.store')}}">
              @csrf
              <input type="hidden" name="user" value="{{Auth::user()->id}}">
              <input type="hidden" name="unique_id" value="{{ $unique_id}}">
              <div class="row">
                  <div class="form-group col-lg-12">
                      <label>Delivery Address</label>
                      <textarea class="form-control" rows="6" name="address" laceholder="Write your address here..." required></textarea>
                  </div>
                  <div class="col-lg-12">
                      <span class="pull-right">By clicking the button below you have agreed with our terms & conditions.</span>
                  </div>
                  <div class="form-group col-lg-12">
                      <button type="submit" class="btn btn-success pull-right">Place Order</button>
                  </div>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')
<script>

</script>
@endsection