@extends('admin.app')

@section('title', 'Access Logs')

@section('admincontent')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-2">
        <h2>Logs</h2>

        <!-- Filter Dropdown and PDF Icon -->
        <div class="d-flex align-items-center">
            <!-- Filter Icon -->
            <div class="dropdown me-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-filter"></i> Sort
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('admin.log', ['sort' => 'asc']) }}">Ascending</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.log', ['sort' => 'desc']) }}">Descending</a></li>
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
                <th>Key</th>
                <th>Details</th>
                <th>Date/Time Borrowed</th>
                <th>Date/Time Returned</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
            <tr>
                <td>{{ $log->faculty_id ?? 'Unknown Faculty' }}</td>
                <td>{{ $log->labKey ? $log->labKey->key_id : 'No Key Assigned' }}</td>
                <td>{{ $log->details ?? 'No Details' }}</td>
                <td>{{ \Carbon\Carbon::parse($log->date_time_borrowed)->format('M d, Y h:i A') }}</td>
                <td>{{ $log->date_time_returned ? \Carbon\Carbon::parse($log->date_time_returned)->format('M d, Y h:i A') : 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No access logs record yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
