<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductsController extends Controller
{
    //
    public function index(){
        $products = Product::latest()->get();
        return view('home' , ['products' => $products]);
    }

    public function show(Product $product){
        return view('product' , compact('product'));
    }
}
