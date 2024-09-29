<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Get the authenticated user
        $authUser = Auth::user();

        // Build the query for ProductCatalog
        $products = ProductCatalog::with('vendor')
            ->when($authUser->isVendor(), function ($queryBuilder) use ($authUser) {
                return $queryBuilder->where('vendor_id', $authUser->vendor->id);
            })
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('product_name', 'like', "%{$query}%");
            })
            ->paginate(10); // Adjust the number to set how many products per page

        return view('products.index', compact('products'));
    }


    public function create()
    {
        // Get the authenticated user
        $authUser = Auth::user();

        // Check the user's role
        if ($authUser->isVendor()) {
            // Get only the approved vendor associated with the authenticated vendor user
            $vendors = Vendor::where('id', $authUser->vendor->id)
                ->where('approved', true)
                ->get();
        } else {
            // For admins, get all approved vendors
            $vendors = Vendor::where('approved', true)->get();
        }

        return view('products.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'product_name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
        ]);

        ProductCatalog::create($request->all());

        // Check the user's role and redirect accordingly
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.products')->with('success', 'Product added successfully!');
        } else {
            return redirect()->route('products.index')->with('success', 'Product added successfully!');
        }
    }
}
