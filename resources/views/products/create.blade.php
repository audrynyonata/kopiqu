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
  <div class="brand" id="products">Create Product</div>
    <div class="row">
        <div class="box">
            <div class="row">
            <div class="col-xs-12 col-lg-12">
                <form role="form" method="POST" action="{{route('products.store')}}">
                    @csrf
                    <input type="hidden" name="stock" value=100>
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control">
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Weight</label>
                            <input type="text" name="weight" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-lg-12">
                            <label>Description</label>
                            <textarea class="form-control" rows="6" name="description"></textarea>
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