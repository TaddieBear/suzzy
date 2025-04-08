@extends('admin.app')

@section('admincontent')

<style>
    .big-card {
        height: 800px; /* Adjust height as needed */
        background-color: #f8f9fa; /* Light gray background */
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .big-card img {
        width: 60%; /* Increased size */
        height: 60%; /* Increased size */
        object-fit: contain;
    }

    .small-card {
        height: 257px; /* Adjust height as needed */
        background-color: #ffffff;
        border-radius: 10px;
        padding: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        margin-bottom: 15px;
    }

    .card-title {
        font-size: 20px;
    }

    .icon {
        font-size: 24px;
        color: #fff; /* Bootstrap primary color */
        margin-right: 10px;
    }

    .data-value {
        font-size: 28px;
        font-weight: bold;
        color: #fcb315;
    }

    .recent-list {
        font-size: 14px;
        padding-left: 0;
        list-style: none;
        color: #fcb315;
    }

    .recent-list li {
        margin-bottom: 5px;
    }
</style>

<!-- Include FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="container-fluid" id="content">
    <div class="row">
        <!-- Big Card on the Left -->
        <div class="col-md-8">
            <div class="card big-card mb-4">
                <img src="{{ asset('images/ccs.png') }}" alt="CCS Logo">
            </div>
        </div>

        <!-- Three Small Cards on the Right -->
        <div class="col-md-4">
            <!-- Faculty Registered -->
            <div class="card small-card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-user-graduate icon"></i> Faculty Registered
                    </h5>
                    <p class="data-value">{{ $facultyCount }}</p>
                    <p class="card-text">Total faculty members registered.</p>
                </div>
            </div>

            <!-- Recently Borrowed -->
            <div class="card small-card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-door-closed icon"></i> Faculty Borrowed
                    </h5>
                    <ul class="recent-list">
                        @forelse ($recentlyBorrowed as $log)
                            <li>
                                <i class="fa-solid fa-user"></i> 
                                {{ $log->faculty ? $log->faculty->fname . ' ' . $log->faculty->lname : 'Unknown Faculty' }} 
                                - {{ \Carbon\Carbon::parse($log->date_time_borrowed)->format('M d, Y h:i A') }}
                            </li>
                        @empty
                            <li>No recent borrows</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Borrowed Keys with Laboratory -->
            <div class="card small-card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-key icon"></i> Borrowed Keys
                    </h5>
                    <ul class="recent-list">
                        @forelse ($recentlyBorrowed as $log)
                            <li>
                                <i class="fa-solid fa-door-open"></i> 
                                {{ $log->labKey ? $log->labKey->laboratory : 'Unknown Lab' }} 
                                ({{ $log->faculty ? $log->faculty->fname . ' ' . $log->faculty->lname : 'Unknown Faculty' }})
                            </li>
                        @empty
                            <li>No borrowed keys</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
