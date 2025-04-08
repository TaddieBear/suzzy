@extends('admin.app')

@section('title', 'Access Logs')

@section('admincontent')
<style>
    .table th, .table td {
        text-align: center;
    }
    .col-date { width: 5%; }
    .col-name { width: 25%; }
    .col-lab { width: 10%; }
    .col-details { width: 15%; }
    .col-time { width: 10%; }
</style>

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-2">
        <h2>Logs</h2>

        <!-- Filter Dropdown and PDF Icon -->
        <div class="d-flex align-items-center">
            <div class="dropdown me-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-filter"></i> Sort
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="{{ route('admin.log', ['sort' => 'asc']) }}">Ascending</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.log', ['sort' => 'desc']) }}">Descending</a></li>
                </ul>
            </div>

            <!-- PDF Button -->
            <button id="printButton" class="btn btn-danger">
                <i class="fa-regular fa-file-pdf"></i> Generate PDF
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="logsTable" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th class="col-date">DATE</th>
                    <th class="col-name">BORROWER'S NAME</th>
                    <th class="col-lab">LABORATORY</th>
                    <th class="col-details">DETAILS (LAB/TV)</th>
                    <th class="col-time">TIME BORROWED</th>
                    <th class="col-time">TIME RETURNED</th>
                    <th class="col-sig">Signature</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($log->date_time_borrowed)->format('M d, Y') }}</td>
                    <td>
                        @if ($log->faculty)
                            {{ $log->faculty->fname }} {{ $log->faculty->mname }} {{ $log->faculty->lname }} {{ $log->faculty->suffix }}
                        @else
                            Unknown Borrower
                        @endif
                    </td>
                    <td>{{ $log->labKey ? $log->labKey->laboratory : 'No Laboratory Assigned' }}</td>
                    <td>{{ $log->details ?? 'No Details' }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->date_time_borrowed)->format('h:i A') }}</td>
                    <td>{{ $log->date_time_returned ? \Carbon\Carbon::parse($log->date_time_returned)->format('h:i A') : 'N/A' }}</td>
                    <td></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No access logs record yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<!-- JavaScript for PDF Export -->
<script src="{{ asset('js/report.js') }}" defer></script>
<script src="{{ asset('js/Report/header.js') }}" defer></script>
<script src="{{ asset('js/Report/footer.js') }}" defer></script>
<script src="{{ asset('js/Report/table.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>


<!-- JavaScript for PDF Export & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function () {
    $('#logsTable').DataTable({
        dom: 'Bfrtip', // Buttons for export
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fa fa-copy"></i> Copy',
                className: 'btn btn-secondary btn-sm'
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-file-csv"></i> CSV',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel"></i> Excel',
                className: 'btn btn-primary btn-sm'
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                orientation: 'landscape'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                className: 'btn btn-dark btn-sm'
            }
        ],
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        language: {
            search: "🔎 Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            paginate: {
                first: "« First",
                last: "Last »",
                next: "›",
                previous: "‹"
            }
        }
    });
});
</script>

@endsection