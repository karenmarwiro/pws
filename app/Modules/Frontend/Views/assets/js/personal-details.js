document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('personalDetailsForm');
    const clearBtn = document.getElementById('clearBtn');
    const backBtn = document.getElementById('backBtn');
    const proceedBtn = document.getElementById('proceedBtn');
    const agreeCheckbox = document.getElementById('agreeTerms');
    const phoneInput = document.getElementById('phone');
    const whatsappInput = document.getElementById('whatsapp');
    const disclaimerSection = document.getElementById('disclaimerSection');
    const formSection = form.parentElement;

    // Initialize phone number formatting
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : `(${x[1]}) ${x[2]}${x[3] ? `-${x[3]}` : ''}`;
        });
    }

    // Initialize WhatsApp number formatting
    if (whatsappInput) {
        whatsappInput.addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : `(${x[1]}) ${x[2]}${x[3] ? `-${x[3]}` : ''}`;
        });
    }

    // Clear form functionality
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            form.reset();
            // Remove validation classes
            const inputs = form.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
                const feedback = input.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.style.display = 'none';
                }
            });
        });
    }

    // Form validation
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Reset previous validation
            const previousErrors = form.querySelectorAll('.is-invalid');
            previousErrors.forEach(el => el.classList.remove('is-invalid'));
            
            // Validate required fields
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    let feedback = field.nextElementSibling;
                    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                        feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = 'This field is required';
                        field.parentNode.insertBefore(feedback, field.nextSibling);
                    }
                    feedback.style.display = 'block';
                    isValid = false;
                } else if (field.type === 'email' && !isValidEmail(field.value)) {
                    field.classList.add('is-invalid');
                    let feedback = field.nextElementSibling;
                    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                        feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = 'Please enter a valid email address';
                        field.parentNode.insertBefore(feedback, field.nextSibling);
                    }
                    feedback.style.display = 'block';
                    isValid = false;
                }
            });
            
            if (isValid) {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                
                // Submit the form via AJAX
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.redirect) {
                        // Show the disclaimer section
                        document.getElementById('personalDetailsForm').style.display = 'none';
                        document.getElementById('disclaimerSection').style.display = 'block';
                        
                        // Scroll to top for better UX
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } else if (data.errors) {
                        // Handle validation errors
                        alert('Please fix the form errors and try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            }
        });
    }
    
    // Helper function to validate email
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    // Add animation to form elements when they come into view
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.form-control, .btn, fieldset');
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };

    // Toggle Proceed button based on checkbox state
    if (agreeCheckbox) {
        agreeCheckbox.addEventListener('change', function() {
            proceedBtn.disabled = !this.checked;
        });
    }
    
    // Back button click handler
    if (backBtn) {
        backBtn.addEventListener('click', function() {
            disclaimerSection.style.display = 'none';
            formSection.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // Proceed button click handler
    if (proceedBtn) {
        proceedBtn.addEventListener('click', function() {
            if (!agreeCheckbox.checked) {
                agreeCheckbox.classList.add('is-invalid');
                return;
            }
            
            // Proceed to the next form (business details)
            window.location.href = '/pbc/business-details';
        });
    }
    
    // Initial check for elements in viewport
    animateOnScroll();
    
    // Check for elements in viewport on scroll
    window.addEventListener('scroll', animateOnScroll);
});
