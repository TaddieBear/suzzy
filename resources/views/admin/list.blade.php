@extends('admin.app')

@section('title', 'Faculty List')

@section('admincontent')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-2">
        <!-- Register Faculty Button -->
        <!-- <a href="#" class="btn btn-primary">Register Faculty</a> -->
        <h2>Faculty List</h2>

        <!-- Filter Dropdown and PDF Icon -->
        <div class="d-flex align-items-center">
            <!-- Filter Icon -->
            <div class="dropdown me-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-filter"></i> Sort
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="#">Ascending</a></li>
                    <li><a class="dropdown-item" href="#">Descending</a></li>
                </ul>
            </div>

            <!-- PDF Icon -->
            <a href="#" class="btn btn-danger">
                <i class="fa-regular fa-file-pdf"></i> PDF
            </a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Faculty ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($faculty as $member)
            <tr>
                <td>{{ $member->faculty_id }}</td>
                <td>{{ $member->fname }} {{ $member->mname }} {{ $member->lname }} {{ $member->suffix }}</td>
                <td>
                    <a href="#" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Toggle Status Button -->
                    <button type="button" class="btn btn-sm {{ $member->status === 'Enabled' ? 'btn-success' : 'btn-danger' }} toggle-status-btn"
                        data-faculty-id="{{ $member->faculty_id }}"
                        data-status="{{ $member->status }}">
                        {{ $member->status === 'Enabled' ? 'Enabled' : 'Disabled' }}
                    </button>

                    <form id="toggle-form-{{ $member->faculty_id }}" action="{{ route('admin.toggleStatus', $member->faculty_id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('PATCH')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No faculty members registered yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- SweetAlert2 Script for Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".toggle-status-btn").forEach(button => {
            button.addEventListener("click", function() {
                let facultyId = this.getAttribute("data-faculty-id");
                let currentStatus = this.getAttribute("data-status");
                let newStatus = currentStatus === "Enabled" ? "Disabled" : "Enabled";
                
                let actionText = newStatus === "Enabled" 
                    ? `Do you want to enable Faculty ID: ${facultyId}?`
                    : `Are you sure you want to disable Faculty ID: ${facultyId}?`;

                let confirmButtonText = newStatus === "Enabled" ? "Yes, Enable it!" : "Yes, Disable it!";
                
                Swal.fire({
                    title: "Confirm Status Change",
                    text: actionText,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: newStatus === "Enabled" ? "#28a745" : "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: confirmButtonText
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`toggle-form-${facultyId}`).submit();
                    }
                });
            });
        });
    });
</script>
@endsection
