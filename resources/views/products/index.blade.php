@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Products</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Variants</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->description }}</td>
                        <td><img src="{{ $product->main_image }}" alt="{{ $product->title }}" width="100"></td>
                        <td>
                            {{-- {{dd($product->variants)}} --}}
                            @if($product->variants)
                                <ul>
                                    @foreach($product->variants as $variant)
                                        <li>{{ $variant['name'] }}: {{ implode(', ', $variant['values']) }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination_area">
            {{ $products->links() }}
        </div>
    </div>
@endsection


