@extends('layouts.app')

@section('header')
<style>
.product-name{
    line-height:1.2em;
    height:2.4em;
    overflow: hidden;
}
</style>
@endsection

@section('content')
<div class="container">
  <div class="brand" id="products">Edit Product</div>
    <div class="row">
        <div class="box">
            <div class="row">
            <div class="col-xs-12 col-lg-12">
                <form role="form" method="POST" action="{{route('products.update', $product->id)}}">
                    {{ method_field('PUT') }}
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label>Product ID</label>
                            <input type="text" readonly class="form-control" value="{{$product->id}}">
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{$product->name}}">
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control"  value="{{$product->price}}">
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Weight</label>
                            <input type="number" name="weight" class="form-control"  value="{{$product->weight}}">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-lg-12">
                            <label>Description</label>
                            <textarea class="form-control" rows="6" name="description">{{$product->description}}</textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <input type="hidden" name="save" value="contact">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>
                </form>
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