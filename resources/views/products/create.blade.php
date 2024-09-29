@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Add Product</h1>

        <form action="{{ Auth::user()->role === 'admin' ? route('admin.products.store') : route('products.store') }}" method="POST" class="mt-4">
            @csrf

            <div class="form-group">
                <label for="vendor_id">Select Vendor</label>
                <select name="vendor_id" class="form-control" required>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="product_name">Product Name</label>
                <input type="text" name="product_name" class="form-control" required>
            </div>

            <div class="form-group mt-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Enter product description"></textarea>
            </div>

            <div class="form-group mt-3">
                <label for="price">Price ($)</label>
                <input type="number" step="0.01" name="price" class="form-control" required placeholder="Enter price">
            </div>

            <button type="submit" class="btn btn-primary mt-4">Add Product</button>
        </form>
    </div>
@endsection
