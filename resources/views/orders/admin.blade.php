@extends('layouts.app')

@section('header')
<style>
.form-control {
width:auto;
display:inline-block;
}

form {
    display:flex;
    justify-content: flex-end;
    align-items: center;
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
  <div class="brand" id="products">Order List</div>
  <div class="row">
    <div class="col-xs-8 col-lg-8 col-xs-offset-2 col-lg-offset-2">
      <div class="box">
        @foreach($orders as $order)
        <h2 class="product-name">Order {{$order->id}}</h2>
        <small>{{$order->created_at}} ordered by <b>{{$order->user->name}}</b> ({{$order->user->email}})</small><br>
        Order ID: {{$order->id}}<br>
        Unique ID: {{$order->unique_id}}<br>
        Address: {{$order->address}}<br>
        Order:
        <ul>
          @foreach($order->order_products as $product)
          <li>{{ $product->product->name }} x {{ $product->quantity }}</li>
          @endforeach
        </ul>
        <p>Amount: Rp{{ $order->amount }}</p>
        <form id="order-{{$order->id}}" action="{{route('orders.update', $order->id)}}">
          <span style="margin-right: auto">Current status : <span class="current-status">{{$order->status}}</span></span>
          <select class="form-control" name="status">
              <option {{$order->status == 'PENDING' ? 'selected' : ''}}>PENDING</option>
              <option {{$order->status == 'PAID' ? 'selected' : ''}}>PAID</option>
              <option {{$order->status == 'SHIPPED' ? 'selected' : ''}}>SHIPPED</option>
          </select>
          <button style="margin-left: 3px"class="btn btn-primary">Update</button>
        </form>
        @endforeach
      </div>
    </form>
    </div>
</div>

@endsection

@section('footer')
<script>
$('document').ready(function(){
        $("[id^='order-']").submit(function(e) {
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
               type: "PUT",
               url: url,
               data: {
                    status: form.find('select').val()
               },
               success: function(data)
               {
                    form.find('.current-status').text(form.find('select').val());
                    console.log(data);
               },
               failed: function(data){
                   console.log(data);
               }
             });
        @endguest
        e.preventDefault();
        });
    })
</script>
@endsection