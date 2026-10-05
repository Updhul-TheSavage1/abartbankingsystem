<link rel="stylesheet" type="text/css" href="../../style/sidebar.css">
<div class="main-wrapper">
  <div class="header-content">

    <div class="header-box-container">

        <div class="header-left">

            <button
                type="button"
                class="mobile-toggle-btn"
                id="mobileMenuToggle"
                aria-label="Open navigation menu"
                aria-expanded="false">
                <i data-lucide="menu"></i>
            </button>

            <div class="header-title-box">
                <h3>Welcome back, Savage</h3>
                <p>Untold &middot; Admin Operations</p>
            </div>

        </div>

        <div class="header-right">

            <div class="date-time">

                <div class="clock-row">
                    <i data-lucide="clock" class="clock-icon"></i>
                    <span id="clock"></span>
                </div>

                <span id="day"></span>

            </div>

        </div>

    </div>

</div>
</div>

<script>
function updateClock(date) {

    const clock = document.getElementById('clock');
    const day = document.getElementById('day');

    if (!clock || !day) return;

    clock.textContent = date.toLocaleTimeString("en-GH", {
        timeZone: "Africa/Accra",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: true
    });

    day.textContent = date.toLocaleDateString("en-GH", {
        timeZone: "Africa/Accra",
        weekday: "long",
        day: "2-digit",
        month: "long",
        year: "numeric"
    });
}

updateClock(new Date());

setInterval(function () {
    updateClock(new Date());
}, 1000);
</script>
