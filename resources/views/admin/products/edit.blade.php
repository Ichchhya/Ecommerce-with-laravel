<x-admin.layout>
    {{-- @can('update-product', $product) --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="az-content az-content-dashboard">
            <div class="container">
              <div class="az-content-body">
                <h2>Update Product {{$product->product_name}}</h2>
                {{-- <x-forms.input type="text" name="full_name"/> --}}
                Product Name: <input type="text" name="product_name" class="form-control" value="{{$product->product_name}}"> <br> <br>
                Product Description: <textarea name="product_desc" id=""  cols="30" rows="10" class="form-control">{{$product->product_desc}}</textarea> <br> <br>
                Price: <input type="text" name="price" id="" class="form-control"  value="{{$product->price}}"> <br> <br>
                Category: 
                <x-forms.select name="category_id">
                    <option value="0" class="form-control">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{$category->id == $product->category_id ? "selected" : '' }} class="form-control">{{$category->category_name}}</option>
                    @endforeach
                </x-forms.select>
                {{-- <select>
                </select> <br> <br> --}}
                <br><br>
                <input type="submit" name="submit" value="Save" >
              </div>
            </div>
        </div>
    </form>
    {{-- @else 
    <br><br>
    <div style="padding:10px; text-align:center; font-weight:bold; font-size:20px; color:red;">Sorry ! You are not authorized to update this product.</div>
    
    <br><br>
    @endcan --}}
    </x-admin.layout>