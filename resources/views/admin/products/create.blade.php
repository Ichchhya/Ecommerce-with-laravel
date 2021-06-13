<x-admin.layout>
  {{-- check if user if authorized to create a product  --}}
  {{-- @can('create', App\Models\Product::class) --}}
    
  {{-- @endcan --}}
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="az-content az-content-dashboard">
        <div class="container">
          <div class="az-content-body">
            @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif

            <h2>Create Product</h2>
            {{-- <x-forms.input type="text" name="full_name"/> --}}
            Product Name: <input type="text" name="product_name" class="form-control" value="{{ old('product_name')}}"
            @error('product_name')
              style="border-color: red;"
            @enderror
            > 
            @error('product_name')
              <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <br><br> 
            Product Description: <textarea name="product_desc" id="" cols="30" rows="10" class="form-control"
            @error('product_desc')
              style="border-color: red;"
            @enderror
            >{{old('product_desc')}}</textarea>
            @error('product_desc')
              <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <br> <br>
            Price: <input type="text" name="price" id="" class="form-control" value="{{ old('price')}}"
            @error('price')
              style="border-color: red;"
            @enderror
            >
            @error('price')
              <div class="alert alert-danger">{{$message}}</div>
            @enderror
            <br> <br>
            Category: 
            <x-forms.select name="category_id">
                <option value="0" class="form-control">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{$category->id == old('category_id') ? "selected" : ''}} class="form-control">{{$category->category_name}}</option>
                @endforeach
            </x-forms.select>
            <br> <br>
            <input type="file" name="image_upload" id="">
            {{-- <select>
            </select> <br> <br> --}}
            <br><br>
            <input type="submit" name="submit" value="Save" >
          </div>
        </div>
    </div>
</form>
</x-admin.layout>