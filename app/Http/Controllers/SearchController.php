<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Clockwork\Storage\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function Search(){
        $products = Product::latest()->search(request(['search', 'category']))->get();
       
        return view('products', ['products'=> $products]);
    }
}
