@extends('product-layout')

@section('menu')
    @include('includes/menu')
@endsection
@section('content')
    <a href="/">Home</a>
    
    <div class="container">
    {{$product->product_name}}
    <div>{!!$product->product_desc!!}</div>
    
    {{$product->price}}
    
    </div>

@endsection 
 
    
