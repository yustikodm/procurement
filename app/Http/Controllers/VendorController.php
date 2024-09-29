<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function create()
    {
        return view('vendors.create');
    }

    public function store(Request $request)
    {
        // Validate incoming data
        $this->validator($request->all())->validate();

        // Create the user first
        $user = User::create([
            'name' => $request->input('company_name'), // Use company name as user name
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Hash the password
            'role' => 'vendor', // Set role to vendor
        ]);

        // Now create the vendor entry with the user_id
        Vendor::create([
            'vendor_type' => $request->input('vendor_type'),
            'company_type' => $request->input('company_type'),
            'identity_number' => $request->input('vendor_type') === 'individual' ? $request->input('identity_number') : null,
            'npwp' => $request->input('npwp'),
            'company_name' => $request->input('company_name'),
            'user_id' => $user->id, // Associate the vendor with the created user
            'approved' => false
        ]);

        return redirect()->route('login')->with('success', 'Vendor registered successfully!');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'vendor_type' => ['required', 'in:individual,national'],
            'company_type' => ['nullable', 'in:BUMN,CV,PT'],
            'identity_number' => ['required_if:vendor_type,individual'],
            'npwp' => ['required'],
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function approveIndex(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $vendors = Vendor::paginate(10); // Adjust the number based on your preference
        return view('vendors.approve', compact('vendors'));
    }

    public function approve(Vendor $vendor): \Illuminate\Http\RedirectResponse
    {
        $vendor->approved = true;
        $vendor->save();

        return redirect()->route('vendors.approve')->with('success', 'Vendor approved successfully!');
    }
}
