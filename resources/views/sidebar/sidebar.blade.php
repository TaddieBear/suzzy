<!-- Sidebar -->
<div class="sidebar collapsed" id="sidebar">
    <!-- Navbar brand moved here with key icon -->
    <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}"> 
        <i class="fa-solid fa-key"></i>
        <span class="d-none d-sm-inline ms-2">Key Cabinet</span>
    </a>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-chart-simple"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.list') }}">
                <i class="fas fa-users"></i> <span>Faculty List</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.labkeys') }}">
                <i class="fa-solid fa-key"></i> <span>LabKeys</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.createFaculty') }}">
                <i class="fas fa-user-plus"></i> <span>Registration</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.log') }}">
                <i class="fa-solid fa-address-card"></i> <span>Logs</span>
            </a>
        </li>
    </ul>
</div>

