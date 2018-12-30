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

.alert-template {
    z-index:999;
    position: fixed;
    top: 0;
    min-width: 75%;
    left: 50%;
    transform: translateX(-50%);
    padding: 70px;
}
.product-name{
    line-height:1.2em;
    height:2.4em;
    overflow: hidden;
}
</style>
@endsection

@section('content')
<div class="container">
  <div class="brand" id="products">Product List</div>
    <div class="row">
        <div class="box">
            <div class="row">
            <div class="col-xs-12 col-lg-12">
                <ul>
                 @foreach($products as $product)
                <li><a href="{{route('products.edit', $product->id) }}">{{ $product->name }}</a></li>                
                @endforeach
                </ul>
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