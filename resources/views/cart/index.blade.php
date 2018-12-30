@extends('layouts.app')

@section('header')
<style>
.form-control {
width:auto;
display:inline-block;
}

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
    <div class="brand" id="products">Shopping Cart</div>
    <form role="form">
        <div class="row">
            <div class="box">
                @php($subtotal_price = 0)
                @php($subtotal_weight = 0)
                @if($carts->isEmpty())
                Cart empty.
                @else
                @foreach($carts as $cart)
                <div class="row">
                  <div class="col-xs-4 col-lg-4">
                    @if($cart->product->product_pictures->isEmpty())
                    <img style="margin-top:20px" class="img-responsive img-border img-left" src="http://via.placeholder.com/350x150" alt="">                
                    @else
                    <img style="margin-top:20px" class="img-responsive img-border img-left" src="{{ asset('img/products/'.$cart->product->product_pictures()->first()->filepath) }}" alt="">
                    @endif
                  </div>
                  <div class="col-xs-8 col-lg-8">
                    <h2 class="intro-text product-name">{{ $cart->product->name }}</h2>
                    <p style="max-height:1.2em;word-wrap: break-word;overflow: hidden">{{ $cart->product->description }}...</p>
                    <div class="form-group">
                      <input type="number" min=1 class="form-control" value="{{$cart->quantity}}" id="quantity-{{$cart->id}}" oninput="changePrice({{$cart->id}},{{$cart->product->price }},{{$cart->product->weight }})">
                      <span>x Rp{{$cart->product->price}} ({{'@'. $cart->product->weight }} kg)</span>
                      <p class="pull-right red"><b>Rp<span class="subtotal_price">{{$cart->quantity * $cart->product->price}}@php($subtotal_price += $cart->quantity * $cart->product->price )</span> (<span class="subtotal_weight">{{ $cart->quantity * $cart->product->weight }}@php($subtotal_weight += $cart->quantity * $cart->product->weight )</span> kg)</b>&nbsp;</p>
                    </div>
                    <br>
                    <button id="remove-{{$cart->id}}"style="margin-left: 3px"class="btn btn-danger">Remove</button>
                  </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="box">
               <div class="col-lg-12" style="text-align: right">
                  <small>SUBTOTAL</small>
                  <h3 class="red">Rp<span id="total_price">{{ $subtotal_price }}</span></h3>
                  <small><span id="total_weight">{{ $subtotal_weight }}</span> kg<br><br></small>
                  <a href="{{ route('orders.create') }}" class="btn btn-success">Proceed to checkout</a>
              </div>
            </div>
        </div>
    </form>
    </div>
</div>

@endsection

@section('footer')
<script>
    function changePrice(id,price,weight){
        var quantity = $("#quantity-"+id);
        var old_price = quantity.siblings('p').find('.subtotal_price').text()
        var old_weight = quantity.siblings('p').find('.subtotal_weight').text()
        var subtotal_price = quantity.siblings('p').find('.subtotal_price').text(Math.round(quantity.val()*price*100) / 100)
        var subtotal_weight = quantity.siblings('p').find('.subtotal_weight').text(Math.round(quantity.val()*weight*100) / 100)

        var total_price = $('#total_price')
        var calculate_price = parseFloat(total_price.text())-parseFloat(old_price)+parseFloat(subtotal_price.text())
        total_price.text(Math.round(calculate_price *100) / 100)
        var total_weight = $('#total_weight')
        var calculate_weight = parseFloat(total_weight.text())-parseFloat(old_weight)+parseFloat(subtotal_weight.text())
        total_weight.text(Math.round(calculate_weight *100) / 100)
    };

    $('document').ready(function(){
        $("[id^='remove-']").click(function(e) {
        @guest
            window.location.replace("{{ route('login')}}");
        @else
            var form = $(this);
            var url = form.attr('action');
            var id = $(this).attr('id').split('-')[1];
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
               type: "DELETE",
               url: '/cart/'+id,
               success: function(result)
               {
                  location.reload();
               },
               failed: function(xhr){
                  console.log(xhr.status);
               }
             });
        @endguest
        e.preventDefault();
        });
    })
</script>
@endsection