@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <h1>Welcome to E-Procurement App</h1>
        <p class="lead">Easily manage your vendor accounts and products</p>
        <div class="mt-4">
            @if (Route::has('login'))
                @if(Auth::check()) <!-- Check if user is authenticated -->
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('vendor.register') }}" class="btn btn-success btn-lg mx-2">Register New Vendor</a>
                    @endif
                @else
                    <a href="{{ route('vendor.register') }}" class="btn btn-success btn-lg mx-2">Register as Vendor</a>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2">Login</a>
                @endif
            @endif

        </div>
    </div>
@endsection
