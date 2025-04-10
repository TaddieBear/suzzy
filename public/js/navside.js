document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.querySelector('.content') || document.getElementById('content');
    const toggleButton = document.getElementById('toggleSidebar');
    const toggleIcon = toggleButton.querySelector('i');

    // Initial collapsed state
    sidebar.classList.add('collapsed');
    navbar.style.width = "100%";
    navbar.style.marginLeft = "0";
    if (content) {
        content.style.marginLeft = "0";
        content.style.width = "100%";
    }

    toggleButton.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
        sidebar.classList.toggle('expanded');
        navbar.classList.toggle('collapsed');
        if (content) {
            content.classList.toggle('expanded');
        }

        const isCollapsed = sidebar.classList.contains('collapsed');

        // Update navbar and content layout
        if (isCollapsed) {
            navbar.style.width = "100%";
            navbar.style.marginLeft = "0";
            if (content) {
                content.style.marginLeft = "0";
                content.style.width = "100%";
            }
            toggleIcon.classList.replace('fa-xmark', 'fa-bars');
        } else {
            navbar.style.width = "calc(100% - 250px)";
            navbar.style.marginLeft = "250px";
            if (content) {
                content.style.marginLeft = "250px";
                content.style.width = "calc(100% - 250px)";
            }
            toggleIcon.classList.replace('fa-bars', 'fa-xmark');
        }
    });
});
