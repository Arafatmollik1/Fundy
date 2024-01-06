$(document).ready(function() {
    // Update theme preference, icon, and button text
    function updateThemePreference(isDarkMode) {
        $('body').attr('data-bs-theme', isDarkMode ? 'dark' : 'light');
        $('#themeSwitcher i').attr('class', isDarkMode ? 'bi bi-moon-fill' : 'bi bi-brightness-high');
        $('#themeSwitcher span').text(isDarkMode ? 'Dark Mode' : 'Light Mode');
    }

    // Load theme preference from localStorage or system preference
    function loadThemePreference() {
        var storedThemePreference = localStorage.getItem('themePreference');
        if (storedThemePreference) {
            return storedThemePreference === 'dark';
        } else {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
    }

    // Initial check and update
    var isDarkMode = loadThemePreference();
    updateThemePreference(isDarkMode);

    // Listen for changes in color scheme
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        updateThemePreference(e.matches);
    });

    // Toggle theme, icon, and button text on click
    $('#themeSwitcher').click(function() {
        var currentTheme = $('body').attr('data-bs-theme');
        if (currentTheme === 'dark') {
            $('body').attr('data-bs-theme', 'light');
            $('#themeSwitcher i').attr('class', 'bi bi-brightness-high');
            $('#themeSwitcher span').text('Light Mode');
            localStorage.setItem('themePreference', 'light');
        } else {
            $('body').attr('data-bs-theme', 'dark');
            $('#themeSwitcher i').attr('class', 'bi bi-moon-fill');
            $('#themeSwitcher span').text('Dark Mode');
            localStorage.setItem('themePreference', 'dark');
        }
    });
});
