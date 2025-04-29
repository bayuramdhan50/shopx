// Custom script to modify Filament logout behavior
document.addEventListener('DOMContentLoaded', function() {
    // Find the logout form in Filament admin panel
    const logoutForms = document.querySelectorAll('form[action*="/logout"]');
    
    logoutForms.forEach(form => {
        // Check if we're in the admin panel
        if (window.location.pathname.includes('/admin')) {
            // Change the form action to use our custom admin logout route
            form.action = '/admin/logout';
        }
    });
});
