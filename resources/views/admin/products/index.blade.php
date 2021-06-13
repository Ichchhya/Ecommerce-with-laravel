<x-admin.layout>
    <div class="az-content az-content-dashboard">
        <div class="container">
          <div class="az-content-body">
            <a href="{{ route('admin.products.create') }}">Create Products</a>
                <table width=900 , align="center">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{$product -> id}}</td>
                        <td>{{$product -> product_name}}</td>
                        <td>{{ substr($product -> product_desc , 0 , 50)}}</td>
                        <td>{{$product -> price}}</td>
                        <td>
                            <a href="{{ route('admin.products.edit' , $product->id)}}">Edit</a> 
                            | 
                            <form method="POST" action="{{route('admin.products.destroy',$product->id)}}"> 
                                @method('DELETE')
                                @csrf
                                <a href="#"onclick="event.preventDefault(); this.closest('form').submit();">Delete</a>
                            </form>
                        </td>  
                    </tr>
                    @endforeach
                </table>
          </div>
        </div>
    </div>

</x-admin.layout>