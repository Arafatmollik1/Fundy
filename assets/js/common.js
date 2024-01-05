$(document).ready(function() {
    // Update theme preference, icon, and button text
    function updateThemePreference() {
        var isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        $('body').attr('data-bs-theme', isDarkMode ? 'dark' : 'light');
        $('#themeSwitcher i').attr('class', isDarkMode ? 'bi bi-moon-fill' : 'bi bi-brightness-high');
        $('#themeSwitcher span').text(isDarkMode ? 'Dark Mode' : 'Light Mode');
    }

    // Initial check
    updateThemePreference();

    // Listen for changes in color scheme
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        updateThemePreference();
    });

    // Toggle theme, icon, and button text on click
    $('#themeSwitcher').click(function() {
        var currentTheme = $('body').attr('data-bs-theme');
        if (currentTheme === 'dark') {
            $('body').attr('data-bs-theme', 'light');
            $('#themeSwitcher i').attr('class', 'bi bi-brightness-high');
            $('#themeSwitcher span').text('Light Mode');
        } else {
            $('body').attr('data-bs-theme', 'dark');
            $('#themeSwitcher i').attr('class', 'bi bi-moon-fill');
            $('#themeSwitcher span').text('Dark Mode');
        }
    });
});
