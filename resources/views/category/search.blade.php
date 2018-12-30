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
    <div class="brand" id="products">{{$category->name}}</div>
    <div class="row">
        <div class="box">
            @foreach($products as $product)
            <div class="col-xs-12 col-sm-4 col-md-3">
                <hr>
                <h2 class="intro-text text-center product-name">{{ $product->name }}</h2>
                <hr>
                @if($product->product_pictures->isEmpty())
                <img class="img-responsive img-border img-left" src="http://via.placeholder.com/350x150" alt="">                
                @else
                <img class="img-responsive img-border img-left" src="{{ asset('img/products/'.$product->product_pictures->first()->filepath) }}" alt="">
                <hr class="visible-xs">
                @endif
                <p>{{$product->description}}</p>
                <small>
                    @foreach($product->category_products as $category)
                        <a href="{{ route('category.search', $category->category->name) }}">{{$category->category->name}}.</a>
                    @endforeach
                </small>
                <form id="form-{{$product->id}}">
                    <small style="margin-right: auto"><b>Rp{{$product->price}}</b> ({{'@'.$product->weight}} kg)</small>
                    <select class="form-control" name="quantity">
                      @for($i=1;$i<=10;$i++)
                      <option>{{$i}}</option>
                      @endfor
                    </select>
                    <button style="margin-left: 3px"class="btn btn-primary">BUY</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    <div class="alert-template" style="display:none">
        <div class="alert alert-success fade in">
            <strong>Success!</strong> Added to cart. 
        </div>
    </div>
    
</div>

@endsection

@section('footer')
<script>
    $('document').ready(function(){
        $("[id^='form-']").submit(function(e) {
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
                   type: "POST",
                   url: '{{ route("cart.store")}}',
                   data: {
                        product: id,
                        user: "{{Auth::user()->id}}",
                        quantity: form.find('select').val()
                   },
                   success: function(data)
                   {
                        var alert = $('.alert-template').clone().insertAfter('#products').css('display', 'inline-block').click(function() {
                          alert.fadeOut( "fast" );
                        });
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