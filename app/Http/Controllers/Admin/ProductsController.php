<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Gate;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Product::latest()->get();
        // return view('admin.products.index', ['products' => $products] );


        if(Auth::user()->role == "admin"){
            $products = Product::latest()->get();
            return view('Admin.Products.index',['products'=>$products]);
        }
        else{
            $id = Auth::id();
            $product = Product::whereUserId($id)->get(); 
            // return $product;
            // $products=products::latest()->where($product->user_id == Auth::User()->id);
            return view('Admin.Products.index',['products'=>$product]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return phpinfo();
        $categories = Category::all();
        return view('admin.products.create' , compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255|unique:products',
            'product_desc' => 'required',
            'price' => 'required',
            'category_id' => 'required|integer|min:1',
        ],
        [
            'required' => ':attribute is a required field',
            'product_name.required' => 'Product Name is a required field. Please fill this up.'
        ],
    );
    
        $product = new Product();
        $product->product_name = $request->input('product_name');
        $product->product_desc = $request->input('product_desc');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->user_id = Auth::id();
        if($request->hasFile('image_upload')){
            //uploading the images to images folder
            $name = $request->file('image_upload')->getClientOriginalName();
            $request->file('image_upload')->storeAs('public/images', $name);
            //cropping the images and saving it in thumbnail folder inside images
            // $image_resize = Image::make(storage_path('app/public/images/'.$name))->resize(550 , 750);
            // $image_resize -> save(storage_path('app/public/images/thumbnail/'.$name));
            image_crop($name , 550, 750);
            $product->image = $name;
        }
        if($product->save()){
            return redirect()->route('admin.products.index');
        }else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit' , compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // $product->product_name = $request->input('product_name');
        // $product->product_desc = $request->input('product_desc');
        // $product->price = $request->input('price');
        // $product->category_id = $request->input('category_id');
        // $product->image= " ";
        // if($product->save()){
        //     return redirect()->route('products_list');
        // }else{
        //     return redirect()->back();
        // }

        //forbids the page to be accecssed by unauthorized user
        //using Gate::allows function to check user authorization
        // if (! Gate::allows('update-product', $product)) {
        //     abort(403);
        // }

        //using Gate::authorize function to check user authorization
        // Gate::authorize('update-product', $product);

        // using authorize helper function to check user authorization
        $this->authorize('update', $product);


        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'product_desc' => 'required',
            'price' => 'required',
            'category_id' => 'required|integer|min:1',
        ],
        [
            'required' => ':attribute is a required field',
            'product_name.required' => 'Product Name is a required field. Please fill this up.'
        ],
    );
    
        $product->product_name = $request->input('product_name');
        $product->product_desc = $request->input('product_desc');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        
        if($request->hasFile('image_upload')){
            //uploading the images to images folder
            $name = $request->file('image_upload')->getClientOriginalName();
            $request->file('image_upload')->storeAs('public/images', $name);
            image_crop($name , 550, 750);
            $product->image = $name;

        }
        if($product->save()){
            return redirect()->route('admin.products.index');
        }else{
            return redirect()->back();
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index');
    }
}
