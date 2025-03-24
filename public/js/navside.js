document.getElementById('toggleSidebar').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const navbar = document.getElementById('navbar');
    const navbarText = document.getElementById('navbarText');
    const toggleIcon = this.querySelector('i'); // Get the icon inside the button

    // Toggle sidebar collapsed state
    sidebar.classList.toggle('collapsed');
    content.classList.toggle('expanded');
    navbar.classList.toggle('collapsed');

    // <i class="fa-solid fa-circle-xmark"></i>
    // Immediately switch the icon
    if (toggleIcon.classList.contains('fa-bars')) {
        toggleIcon.classList.replace('fa-bars', 'fa-xmark'); // Change to left arrow on click
    } else {
        toggleIcon.classList.replace('fa-xmark', 'fa-bars'); // Change back to right arrow
    }
});
