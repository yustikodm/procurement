@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Vendor Approval</h2>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Vendor Type</th>
                        <th>Company Type</th>
                        <th>Identity Number</th>
                        <th>NPWP</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td>{{ $vendor->id }}</td>
                            <td>{{ $vendor->company_name }}</td>
                            <td>{{ $vendor->user->email }}</td>
                            <td>{{ $vendor->vendor_type }}</td>
                            <td>{{ $vendor->company_type }}</td>
                            <td>{{ $vendor->identity_number }}</td>
                            <td>{{ $vendor->npwp }}</td>
                            <td>{{ $vendor->approved ? 'Active' : 'Not Active' }}</td>
                            <td>
                                @if (!$vendor->approved)
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal-{{ $vendor->id }}">Approve</button>
                                @else
                                    <span class="text-muted">Approved</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    {{ $vendors->links() }} <!-- This will render pagination links -->
                </div>
            </div>
        </div>

        <!-- Modal for approving vendors -->
        @foreach ($vendors as $vendor)
            <div class="modal fade" id="approveModal-{{ $vendor->id }}" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Approve Vendor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to approve vendor <strong>{{ $vendor->company_name }}</strong>?
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="{{ route('vendors.approve.vendor', $vendor) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
