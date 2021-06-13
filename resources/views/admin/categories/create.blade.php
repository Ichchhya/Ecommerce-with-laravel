<x-admin.layout>
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
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
    
                <h2>Create Category</h2>
                Category Name: <input type="text" id="category_name" name="category_name" class="form-control" value="{{ old('category_name')}}"
                @error('category_name')
                  style="border-color: red;"
                @enderror
                > 
                <br><br> 
                Category Slug: <input type="text" id ="slug" name="slug" class="form-control" value="{{ old('slug')}}"
                @error('slug')
                  style="border-color: red;"
                @enderror
                > 
                <br><br>
                Category Description: <textarea name="category_description" id="" cols="30" rows="10" class="form-control"
                @error('category_description')
                  style="border-color: red;"
                @enderror
                >{{old('category_description')}}</textarea>
                <br> <br>
                Parent Category: 
                <x-forms.select name="parent_id">
                    <option value="0" class="form-control">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" {{$category->id == old('parent_id') ? "selected" : ''}} class="form-control">{{$category->category_name}}</option>
                    @endforeach
                </x-forms.select>
                <br> <br>
                <input type="submit" name="submit" value="Save" >
              </div>
            </div>
        </div>
    </form>
    </x-admin.layout>
<script>
    jQuery(document).ready(function($){
        $('#category_name').on('change',function(){
            var name=$('#category_name').val();
            var slug = name.replace(/\s+/g,'-').toLowerCase();
            $('#slug').val(slug);
        })
    })
</script>
    