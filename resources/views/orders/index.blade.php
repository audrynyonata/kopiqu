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
    <div class="brand" id="products">My Order</div>
    <div class="col-xs-12 col-lg-12">
      <div class="box">
        @foreach($orders as $order)
        <hr>
        <h2 class="intro-text text-center product-name">Order {{$order->id}}</h2>
        <hr>
        <small>{{$order->created_at}}</small>
        <p>
        {{$order->address}}<br>
        Rp{{ $order->amount }}</p>
        <span class="red">Status: {{$order->status}}</span>
        <br>
        Order:
        <ul>
          @foreach($order->order_products as $product)
          <li>{{ $product->product->name }} x {{ $product->quantity }}</li>
          @endforeach
        </ul>
        @endforeach
      </div>  
    </div>
    </div>
  </div>
</div>

@endsection

@section('footer')
<script>

</script>
@endsection