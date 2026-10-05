document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const backdrop = document.getElementById("sidebarBackdrop");
    const menuToggle = document.getElementById("mobileMenuToggle");
    const closeButton = document.getElementById("sidebarCloseBtn");

    if (!sidebar) return;

    function openSidebar() {
        sidebar.classList.add("open");

        if (backdrop) {
            backdrop.classList.add("show");
        }

        document.body.classList.add("menu-open");

        if (menuToggle) {
            menuToggle.setAttribute("aria-expanded", "true");
        }
    }

    function closeSidebar() {
        sidebar.classList.remove("open");

        if (backdrop) {
            backdrop.classList.remove("show");
        }

        document.body.classList.remove("menu-open");

        if (menuToggle) {
            menuToggle.setAttribute("aria-expanded", "false");
        }
    }

    if (menuToggle) {
        menuToggle.addEventListener("click", function () {
            if (sidebar.classList.contains("open")) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    if (closeButton) {
        closeButton.addEventListener("click", closeSidebar);
    }

    if (backdrop) {
        backdrop.addEventListener("click", closeSidebar);
    }

    // Close the mobile sidebar after selecting a navigation item.
    sidebar.querySelectorAll("a").forEach(function (link) {
        link.addEventListener("click", function () {
            if (window.innerWidth <= 1024) {
                closeSidebar();
            }
        });
    });

    // If the screen becomes desktop-sized, reset the mobile state.
    window.addEventListener("resize", function () {
        if (window.innerWidth > 1024) {
            closeSidebar();
        }
    });

    // Initialize Lucide icons if the library is available.
    if (typeof lucide !== "undefined") {
        lucide.createIcons();
    }
});
