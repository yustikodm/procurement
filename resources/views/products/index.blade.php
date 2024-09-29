@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">Product Catalog</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ Auth::user()->isAdmin() ? route('admin.products') : route('products.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search for products..." value="{{ request()->input('query') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>


        <!-- Conditional Button for Adding Product -->
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.products.create') : route('products.create') }}" class="btn btn-success">Add Product</a>

        <table class="table mt-4">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Vendor</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->vendor->company_name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4">
            {{ $products->links() }} <!-- This will render pagination links -->
        </div>
    </div>
@endsection
