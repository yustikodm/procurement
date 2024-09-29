@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white text-center">{{ __('Register as Vendor') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                            <form method="POST" action="{{ route('vendor.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Vendor Type Field -->
                                <div class="mb-3">
                                    <label for="vendor_type" class="form-label">{{ __('Vendor Type') }}</label>
                                    <select name="vendor_type" id="vendorType" class="form-control">
                                        <option value="individual">Individual</option>
                                        <option value="national">National</option>
                                    </select>
                                </div>

                                <!-- Email Field -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <!-- Password Field -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                                <!-- Company Name / Name Field (Dynamic Label) -->
                                <div class="mb-3">
                                    <label for="company_name" id="companyNameLabel" class="form-label">{{ __('Company Name') }}</label>
                                    <input type="text" name="company_name" class="form-control" required>
                                </div>

                                <!-- Company Type (Hidden if Individual) -->
                                <div class="mb-3" id="vendorClassField">
                                    <label for="vendor_class" class="form-label">{{ __('Company Type') }}</label>
                                    <select name="company_type" class="form-control">
                                        <option value="BUMN">BUMN</option>
                                        <option value="CV">CV</option>
                                        <option value="PT">PT</option>
                                    </select>
                                </div>

                                <!-- KTP Field (Visible only if Individual) -->
                                <div class="mb-3" id="ktpField">
                                    <label for="ktp" class="form-label">{{ __('Identity Number') }}</label>
                                    <input type="text" name="identity_number" class="form-control">
                                </div>

                                <!-- NPWP Field -->
                                <div class="mb-3" id="npwpField">
                                    <label for="npwp" class="form-label">{{ __('NPWP') }}</label>
                                    <input type="text" name="npwp" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-success w-100">Register</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle field visibility based on vendor type
        document.addEventListener('DOMContentLoaded', function () {
            const vendorTypeSelect = document.getElementById('vendorType');
            const companyNameLabel = document.getElementById('companyNameLabel');
            const vendorClassField = document.getElementById('vendorClassField');
            const ktpField = document.getElementById('ktpField');
            const npwpField = document.getElementById('npwpField');

            function updateFormFields() {
                const vendorType = vendorTypeSelect.value;

                if (vendorType === 'individual') {
                    // Change label to "Name" and hide company type
                    companyNameLabel.innerText = 'Name';
                    vendorClassField.style.display = 'none';
                    ktpField.style.display = 'block'; // Show KTP field
                    npwpField.style.display = 'block'; // NPWP is optional
                } else if (vendorType === 'national') {
                    // Change label to "Company Name" and show company type
                    companyNameLabel.innerText = 'Company Name';
                    vendorClassField.style.display = 'block';
                    ktpField.style.display = 'none'; // Hide KTP field
                    npwpField.style.display = 'block'; // NPWP is required
                }
            }

            // Run on page load and when vendor type changes
            updateFormFields();
            vendorTypeSelect.addEventListener('change', updateFormFields);
        });
    </script>
@endsection
