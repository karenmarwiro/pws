<!-- Settings Page Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Apply saved theme and color scheme
    function applyTheme() {
        const theme = '<?= $settings['theme'] ?? 'default' ?>';
        const colorScheme = '<?= $settings['color_scheme'] ?? 'light' ?>';
        
        // Remove existing theme classes
        document.documentElement.classList.remove('theme-default', 'theme-dark', 'theme-light', 'theme-blue');
        document.body.classList.remove('light-mode', 'dark-mode');
        
        // Apply selected theme
        document.documentElement.classList.add(`theme-${theme}`);
        document.body.classList.add(`${colorScheme}-mode`);
    }
    
    // Initialize theme
    applyTheme();
    
    // Form submission handling
    const settingsForm = document.getElementById('settings-form');
    const saveButton = document.getElementById('save-settings-btn');
    const saveSpinner = document.getElementById('save-spinner');

    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            if (saveButton) saveButton.disabled = true;
            if (saveSpinner) saveSpinner.classList.remove('d-none');
            
            // Get form data
            const formData = new FormData(settingsForm);
            
            // Send AJAX request
            fetch(settingsForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(formData).toString()
            })
            .then(response => response.json())
            .then(data => {
                // Show success message
                if (data.success) {
                    showToast('Settings saved successfully. Page will refresh in 2 seconds...', 'success');
                    // Apply theme changes immediately
                    applyTheme();
                    
                    // Refresh the page after a short delay to apply all settings
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showToast(data.message || 'Error saving settings', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred while saving settings', 'error');
            })
            .finally(() => {
                // Reset loading state
                if (saveButton) saveButton.disabled = false;
                if (saveSpinner) saveSpinner.classList.add('d-none');
            });
        });
    }
    
    // Toast notification function
    function showToast(message, type = 'info') {
        // You can implement a toast notification system here
        alert(`${type.toUpperCase()}: ${message}`);
    }
});
</script>
