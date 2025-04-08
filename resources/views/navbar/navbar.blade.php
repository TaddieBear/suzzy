<!-- Navbar -->
<nav class="navbar navbar-dark bg-white dark-mode-bg" id="navbar">
    <div class="container-fluid">
        <div class="me-auto">
            {{-- <button class="btn btn-dark" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button> --}}
            <span id="navbarText" class="ms-2"><i class="fa-solid fa-key"></i> Key Cabinet Registration</span>
        </div>
        <div class="ms-auto d-flex align-items-center">
            <!-- Dark Mode Toggle Button 
            <button id="darkModeToggle" class="btn btn-dark text-white btn-outline-dark mx-2">
                <i class="fas fa-moon"></i> Default Moon Icon 
            </button>-->

            <a href="{{ route('admin.logout') }}" class="btn-logout text-dark d-flex align-items-center" 
               data-bs-toggle="tooltip" title="Logout"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</nav>
