<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SearchController;
use App\Models\Order;
use App\Http\Controllers\OrderItemController;
use App\Models\OrderItem;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
     $products=Product::all();
     $category = Category::all();
    //  return $category;
    return view('home',['products'=>$products , 'category'=>$category ]);
});

Route::get('/checkout', function () {
   return view('checkout');
});   

// Route::get('order' ,[App\Http\Controllers\OrderController::class , 'index']);
// Route::resource('cart', OrderItemController::class);

Route::get('/products/{product}', function (Product $product) {
   // $product=Product::find($id);
    return view('product',['product'=> $product]);
});
Route::get('/create_product',function(){
    Product::create ([
        'product_name'=>'Laptop',
        'product_desc'=>'This is very nice laptop',
        'price'=>'1000000',
        'image'=>''
    ]);
});
Route::get('/home',[ProductsController::class,'index']);
Route::get('/search',[App\Http\Controllers\SearchController::class,'search'])->name('search');
Route::resource('products',ProductsController::class)->only(['index','show']);



Route::get('/categories/{category}',function(Category $category){
    //$products=Product::whereCategoryId($category->id)->get();
    $products = $category->products;
    return view('category',['products'=>$products,'category'=>$category]);
});

Route::resource('order' ,App\Http\Controllers\OrderController::class);
Route::resource('cart' ,App\Http\Controllers\OrderItemController::class)->middleware('auth');

//admin route

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/products', [App\Http\Controllers\Admin\ProductsController::class, 'index'])->name('products_list');
    // Route::get('/products/create', [App\Http\Controllers\Admin\ProductsController::class, 'create'])->name('create_product');
    // Route::post('/products/store', [App\Http\Controllers\Admin\ProductsController::class, 'store']);
    // Route::get('/products/edit/{product}', [App\Http\Controllers\Admin\ProductsController::class, 'edit']);
    // Route::post('/products/update/{product}',[App\Http\Controllers\Admin\ProductsController::class,'update'])->name('update');
    // Route::get('/products/delete/{product}',[App\Http\Controllers\Admin\ProductsController::class,'destroy'])->name('delete');
    Route::resource('categories' ,App\Http\Controllers\Admin\CategoriesController::class);
    Route::resource('products' ,App\Http\Controllers\Admin\ProductsController::class);
});