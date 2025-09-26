/**
 * Settings Page JavaScript
 * Handles form validation, tabs, and AJAX submission
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                handleFormSubmit(event, form);
            }
            
            form.classList.add('was-validated');
        }, false);
    });

    // Handle form submission with AJAX
    async function handleFormSubmit(event, form) {
        event.preventDefault();
        event.stopPropagation();
        
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            ${submitButton.dataset.loadingText || 'Saving...'}
        `;
        
        try {
            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const csrfName = document.querySelector('meta[name="csrf-token-name"]')?.content || 'csrf_test_name';
            
            // Add CSRF token to the form data if not already present
            if (!formData.has(csrfName)) {
                formData.append(csrfName, csrfToken);
            }
            
            // Create headers for the request
            const headers = new Headers();
            headers.append('X-Requested-With', 'XMLHttpRequest');
            headers.append('X-CSRF-TOKEN', csrfToken);
            
            // For file uploads, we need to use FormData with the correct content type
            const hasFiles = Array.from(form.elements).some(el => el.type === 'file' && el.files.length > 0);
            
            let options = {
                method: 'POST',
                headers: headers,
                body: formData,
                credentials: 'same-origin'
            };
            
            // If no files are being uploaded, we can send as JSON
            if (!hasFiles) {
                const jsonData = {};
                formData.forEach((value, key) => {
                    // Handle checkboxes
                    if (key.endsWith('_notifications') || key === 'remove_logo' || key === 'remove_favicon') {
                        jsonData[key] = value === 'on' ? true : false;
                    } else {
                        jsonData[key] = value;
                    }
                });
                
                options.headers.set('Content-Type', 'application/json');
                options.body = JSON.stringify(jsonData);
            }
            
            // Make the AJAX request
            const response = await fetch(form.action, options);
            
            // Check if the response is JSON
            const contentType = response.headers.get('content-type');
            const isJson = contentType && contentType.includes('application/json');
            const result = isJson ? await response.json() : { success: false, message: await response.text() };
            
            // If the response is not OK, throw an error
            if (!response.ok) {
                throw new Error(result.message || 'An error occurred while saving the settings');
            }
            
            // If we get here, the request was successful
            if (result.success) {
                // Show success message
                showAlert('success', result.message || 'Settings saved successfully!');
                
                // Update last updated time
                const now = new Date();
                const options = { 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit' 
                };
                const lastUpdated = document.getElementById('last-updated');
                if (lastUpdated) {
                    lastUpdated.textContent = now.toLocaleDateString('en-US', options);
                }
                
                // Handle theme changes
                if (result.theme) {
                    document.documentElement.setAttribute('data-bs-theme', result.theme);
                }
                
                // Handle language changes
                if (result.reload) {
                    setTimeout(() => window.location.reload(), 1000);
                }
                
                // Handle file upload previews
                if (result.data?.logo) {
                    const logoPreview = document.querySelector('.logo-preview');
                    if (logoPreview) {
                        logoPreview.src = result.data.logo + '?t=' + new Date().getTime();
                        logoPreview.classList.remove('d-none');
                    }
                }
                
                if (result.data?.favicon) {
                    const favicon = document.querySelector('link[rel="icon"]');
                    if (favicon) {
                        favicon.href = result.data.favicon + '?t=' + new Date().getTime();
                    }
                }
            } else {
                throw new Error(result.message || 'Failed to save settings');
            }
        } catch (error) {
            console.error('Error:', error);
            let errorMessage = 'An error occurred while saving settings';
            
            if (error instanceof Error) {
                errorMessage = error.message;
            } else if (typeof error === 'string') {
                errorMessage = error;
            } else if (error.response) {
                // Handle HTTP error responses
                errorMessage = error.response.message || `HTTP error: ${error.response.status}`;
            }
            
            showAlert('danger', errorMessage);
        } finally {
            // Reset button state
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
            
            // Remove the 'was-validated' class to reset validation
            form.classList.remove('was-validated');
        }
    }
    
    // Show alert message
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Remove any existing alerts
        const existingAlerts = document.querySelectorAll('.alert-dismissible');
        existingAlerts.forEach(alert => alert.remove());
        
        // Add new alert
        const header = document.querySelector('h1');
        if (header) {
            header.insertAdjacentHTML('afterend', alertHtml);
        } else {
            document.querySelector('.container').insertAdjacentHTML('afterbegin', alertHtml);
        }
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }
    
    // Handle tab changes and save to localStorage
    const tabLinks = document.querySelectorAll('[data-bs-toggle="pill"]');
    tabLinks.forEach(link => {
        link.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem('settingsActiveTab', e.target.getAttribute('href'));
        });
    });
    
    // Restore active tab from localStorage
    const activeTab = localStorage.getItem('settingsActiveTab');
    if (activeTab) {
        const tabElement = document.querySelector(`[href="${activeTab}"]`);
        if (tabElement) {
            new bootstrap.Tab(tabElement).show();
        }
    }
    
    // Handle theme preview
    const themeSelect = document.getElementById('theme');
    if (themeSelect) {
        themeSelect.addEventListener('change', function() {
            document.documentElement.setAttribute('data-bs-theme', this.value);
            // Don't submit the form, just preview
            event.preventDefault();
            event.stopPropagation();
            return false;
        });
    }
    
    // Handle color scheme toggle
    const colorSchemeToggle = document.getElementById('colorSchemeToggle');
    if (colorSchemeToggle) {
        colorSchemeToggle.addEventListener('change', function() {
            const isDark = this.checked;
            document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
        });
    }
    
    // Handle language change
    const languageSelect = document.getElementById('language');
    if (languageSelect) {
        languageSelect.addEventListener('change', function() {
            // The form will handle the submission via the normal submit handler
            // which will trigger a page reload if the language changes
        });
    }
    
    // Initialize code editors if any
    if (typeof CodeMirror !== 'undefined') {
        const textareas = document.querySelectorAll('textarea[data-editor]');
        textareas.forEach(textarea => {
            const mode = textarea.dataset.editor;
            const editor = CodeMirror.fromTextArea(textarea, {
                mode: mode,
                lineNumbers: true,
                lineWrapping: true,
                theme: 'default',
                indentUnit: 4,
                autofocus: false
            });
            
            // Update the original textarea when the editor content changes
            editor.on('change', function() {
                textarea.value = editor.getValue();
            });
            
            // Store the editor instance for later access if needed
            textarea.codemirror = editor;
        });
    }
    
    // Handle file uploads with preview
    const fileInputs = document.querySelectorAll('.file-upload-input');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            
            const previewId = this.dataset.preview;
            const previewElement = previewId ? document.getElementById(previewId) : null;
            
            if (previewElement) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewElement.src = e.target.result;
                        previewElement.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewElement.textContent = file.name;
                    previewElement.classList.remove('d-none');
                }
            }
        });
    });
    
    // Handle reset buttons
    const resetButtons = document.querySelectorAll('.btn-reset');
    resetButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const targetElement = targetId ? document.getElementById(targetId) : null;
            if (targetElement) {
                if (targetElement.tagName === 'SELECT') {
                    targetElement.selectedIndex = 0;
                } else if (targetElement.tagName === 'INPUT') {
                    if (targetElement.type === 'checkbox' || targetElement.type === 'radio') {
                        targetElement.checked = targetElement.defaultChecked;
                    } else {
                        targetElement.value = targetElement.defaultValue;
                    }
                } else if (targetElement.tagName === 'TEXTAREA') {
                    targetElement.value = targetElement.defaultValue;
                }
                
                // Trigger change event
                const event = new Event('change');
                targetElement.dispatchEvent(event);
            }
        });
    });
});

// Change language function
function changeLanguage(lang) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= site_url("settings/set_language") ?>';
    
    const csrfField = document.createElement('input');
    csrfField.type = 'hidden';
    csrfField.name = '<?= csrf_token() ?>';
    csrfField.value = '<?= csrf_hash() ?>';
    
    const langField = document.createElement('input');
    langField.type = 'hidden';
    langField.name = 'language';
    langField.value = lang;
    
    form.appendChild(csrfField);
    form.appendChild(langField);
    
    document.body.appendChild(form);
    form.submit();
}

// Export functions for use in other scripts
window.Settings = {
    showAlert: showAlert,
    changeLanguage: changeLanguage
};
