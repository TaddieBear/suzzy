<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Font (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <script>
        // Apply dark mode only to navbar and sidebar if saved in localStorage
        if (localStorage.getItem("theme") === "dark") {
            document.documentElement.classList.add("dark-mode");
        }
    </script>
</head>
<body class="bg-light text-dark">

    @include('sidebar.sidebar')
    @include('navbar.navbar')

    <!-- Main Content -->
    <div class="content expanded" id="content">
        @yield('admincontent')
    </div>

    <script src="{{ asset('js/navside.js') }}" defer></script>
    <script src="{{ asset('js/darkmode.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
