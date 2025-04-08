@extends('admin.app')

@section('admincontent')

<style>
    .card {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }
    #darkModeContainer {
        bottom: 50px !important; /* Moves it higher from the bottom */
        right: 25px;
        z-index: 1050;
    }

    #darkModeToggle {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    }
    /* Hover Animation */
        #darkModeToggle:hover {
            transform: scale(1.1) rotate(10deg); /* Slight rotation and scaling */
            background-color: #222; /* Slightly darker shade */
            box-shadow: 0px 4px 12px rgba(255, 255, 255, 0.5); /* Soft glow effect */
        }

        /* Glow effect */
        #darkModeToggle::before {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        /* Activate glow effect on hover */
        #darkModeToggle:hover::before {
            opacity: 1;
            transform: scale(1.2);
        }
        /* Custom Password Field Styling */
        input[type="password"] {
            font-family: 'Font Awesome 6 Free', Arial, sans-serif;
            font-weight: 900;
            letter-spacing: 3px;
        }

        /* Replace password dots with fa-asterisk */
        input[type="password"]::placeholder {
            font-family: 'Font Awesome 6 Free', Arial, sans-serif;
            font-weight: 900;
            content: '\f069' !important; /* Unicode for fa-asterisk */
        }
        #scanner-status {
            position: absolute;
            top: 130px; /* Adjust as needed */
            right: 20px;
            z-index: 1050;
            display: none;
            transition: opacity 0.5s ease-in-out;
            padding: 5px !important;
        }


</style>
<div class="container">
    <div class="row justify-content-center">
        <!-- Faculty Registration Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Faculty Registration</div>

                <div class="card-body">
                    <form action="{{ route('admin.store') }}" method="POST" id="faculty-registration-form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="faculty_id" class="form-label">Faculty ID</label>
                                <input type="text" class="form-control @error('faculty_id') is-invalid @enderror" id="faculty_id" name="faculty_id" required>
                                @error('faculty_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        

                            <div class="col-6 mb-3">
                                <label for="rfid_uid" class="form-label">RFID UID</label>
                                <input type="password" class="form-control" id="rfid_uid" name="rfid_uid" readonly>

                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" required>
                            @error('fname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mname" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="mname" name="mname">
                        </div>

                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" required>
                            @error('lname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="suffix" class="form-label">Suffix (e.g., Jr., Sr.)</label>
                            <input type="text" class="form-control" id="suffix" name="suffix">
                        </div>

                        <button type="submit" class="btn btn-dark">Register</button>
                        <button type="button" class="btn btn-secondary" id="clear-btn">Clear</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Key Registration Form (Right side container) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Key Registration</div>

                <div class="card-body">
                    <form action="{{ route('admin.labkeys.store') }}" method="POST" id="key-registration-form">
                        @csrf

                        <div class="mb-3">
                            <label for="key_id" class="form-label">Key ID</label>
                            <input type="text" class="form-control @error('key_id') is-invalid @enderror" id="key_id" name="key_id" required>
                            @error('key_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="laboratory" class="form-label">Laboratory</label>
                            <input type="text" class="form-control @error('laboratory') is-invalid @enderror" id="laboratory" name="laboratory" required>
                            @error('laboratory')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-dark">Register Key</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Toast Messages -->
<div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="toast-container">
        @if(session('success'))
            <div class="toast align-items-center text-bg-dark border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-times-circle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Dark Mode Toggle Button -->
<div id="darkModeContainer" class="position-fixed bottom-0 end-0 p-3">
    <button id="darkModeToggle" class="btn btn-dark text-white btn-outline-dark">
        <i class="fas fa-moon"></i> <!-- Default Moon Icon -->
    </button>
</div>


<!-- Include the JavaScript file -->
<script src="{{ asset('js/nfc-auth.js') }}" defer></script>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    var toastElements = document.querySelectorAll('.toast');
    toastElements.forEach(toastEl => new bootstrap.Toast(toastEl).show());

    const rfidInput = document.getElementById('rfid_uid');
    const facultyForm = document.getElementById('faculty-registration-form');

    rfidInput.value = '';

    document.getElementById('clear-btn').addEventListener('click', function () {
        facultyForm.reset();
        rfidInput.value = '';
    });

    rfidInput.addEventListener('input', function () {
        this.value = this.value.toUpperCase();
    });

    facultyForm.addEventListener('submit', function () {
        setTimeout(() => {
            rfidInput.value = '';
        }, 100);
    });
});

</script>

@endsection
