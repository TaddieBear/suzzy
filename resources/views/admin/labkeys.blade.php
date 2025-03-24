@extends('admin.app')

@section('title', 'Laboratory Keys')

@section('admincontent')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-2">
        <h2>Lab Keys</h2>

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
                <th>Key ID</th>
                <th>Laboratory</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($labKeys as $labKey)
            <tr>
                <td>{{ $labKey->key_id }}</td>
                <td>{{ $labKey->laboratory }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="text-center">No keys record yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('styles')
<style>
    .dropdown-toggle {
        font-size: 14px;
    }

    .btn i {
        margin-right: 5px;
    }
</style>
@endpush
