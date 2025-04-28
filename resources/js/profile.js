/**
 * Profile page functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggles
    initializePasswordToggles();
    
    // Smooth scrolling for sidebar navigation
    initializeSmoothScrolling();
    
    // Form validation for profile updates
    initializeFormValidation();
    
    // Password strength meter
    initializePasswordStrengthMeter();
});

/**
 * Initialize password visibility toggles
 */
function initializePasswordToggles() {
    const toggles = document.querySelectorAll('.password-toggle');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            // Change the eye icon
            const eye = this.querySelector('.password-eye');
            if (type === 'text') {
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        });
    });
}

/**
 * Initialize smooth scrolling for sidebar navigation
 */
function initializeSmoothScrolling() {
    const sidebarLinks = document.querySelectorAll('.profile-sidebar-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                // Add active class to the clicked link
                sidebarLinks.forEach(link => link.classList.remove('bg-indigo-50', 'text-indigo-700'));
                this.classList.add('bg-indigo-50', 'text-indigo-700');
                
                // Smooth scroll to the target section
                window.scrollTo({
                    top: targetElement.offsetTop - 30,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Set active link on page load
    setActiveSidebarLink();
    
    // Update active link on scroll
    window.addEventListener('scroll', function() {
        setActiveSidebarLink();
    });
}

/**
 * Set the active sidebar link based on scroll position
 */
function setActiveSidebarLink() {
    const sections = document.querySelectorAll('section');
    const sidebarLinks = document.querySelectorAll('.profile-sidebar-link');
    
    let currentSection = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        
        if (window.scrollY >= (sectionTop - 100)) {
            currentSection = '#' + section.getAttribute('id');
        }
    });
    
    sidebarLinks.forEach(link => {
        link.classList.remove('bg-indigo-50', 'text-indigo-700');
        if (link.getAttribute('href') === currentSection) {
            link.classList.add('bg-indigo-50', 'text-indigo-700');
        }
    });
}

/**
 * Initialize form validation
 */
function initializeFormValidation() {
    const profileForm = document.querySelector('form[action*="profile.update"]');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            // Simple client-side validation for email
            const emailInput = this.querySelector('input[name="email"]');
            if (emailInput && !isValidEmail(emailInput.value)) {
                e.preventDefault();
                showValidationError(emailInput, 'Please enter a valid email address');
            }
            
            // Phone validation (optional)
            const phoneInput = this.querySelector('input[name="phone"]');
            if (phoneInput && phoneInput.value && !isValidPhone(phoneInput.value)) {
                e.preventDefault();
                showValidationError(phoneInput, 'Please enter a valid phone number');
            }
        });
    }
}

/**
 * Initialize password strength meter
 */
function initializePasswordStrengthMeter() {
    const passwordInput = document.querySelector('input[name="password"]');
    if (passwordInput) {
        const meterContainer = document.createElement('div');
        meterContainer.classList.add('mt-2');
        meterContainer.innerHTML = `
            <div class="password-strength">
                <div class="flex space-x-1">
                    <div class="h-1 w-1/4 rounded-full bg-gray-200"></div>
                    <div class="h-1 w-1/4 rounded-full bg-gray-200"></div>
                    <div class="h-1 w-1/4 rounded-full bg-gray-200"></div>
                    <div class="h-1 w-1/4 rounded-full bg-gray-200"></div>
                </div>
                <p class="text-xs mt-1 text-gray-500">Password strength: <span>None</span></p>
            </div>
        `;
        
        passwordInput.parentNode.insertBefore(meterContainer, passwordInput.nextSibling);
        
        passwordInput.addEventListener('input', function() {
            updatePasswordStrength(this.value);
        });
    }
}

/**
 * Update password strength meter
 */
function updatePasswordStrength(password) {
    const strengthBars = document.querySelectorAll('.password-strength .h-1');
    const strengthText = document.querySelector('.password-strength span');
    
    if (!strengthBars.length || !strengthText) return;
    
    // Reset all bars
    strengthBars.forEach(bar => {
        bar.classList.remove('bg-red-500', 'bg-yellow-500', 'bg-green-500', 'bg-indigo-500');
        bar.classList.add('bg-gray-200');
    });
    
    if (!password) {
        strengthText.textContent = 'None';
        return;
    }
    
    // Calculate password strength
    let strength = 0;
    
    // Length check
    if (password.length > 7) strength++;
    if (password.length > 10) strength++;
    
    // Complexity checks
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    // Cap at 4
    strength = Math.min(strength, 4);
    
    // Update visual indicators
    for (let i = 0; i < strength; i++) {
        strengthBars[i].classList.remove('bg-gray-200');
        
        if (strength === 1) {
            strengthBars[i].classList.add('bg-red-500');
            strengthText.textContent = 'Weak';
            strengthText.classList.add('text-red-500');
            strengthText.classList.remove('text-yellow-500', 'text-green-500', 'text-indigo-500');
        } else if (strength === 2) {
            strengthBars[i].classList.add('bg-yellow-500');
            strengthText.textContent = 'Fair';
            strengthText.classList.add('text-yellow-500');
            strengthText.classList.remove('text-red-500', 'text-green-500', 'text-indigo-500');
        } else if (strength === 3) {
            strengthBars[i].classList.add('bg-green-500');
            strengthText.textContent = 'Good';
            strengthText.classList.add('text-green-500');
            strengthText.classList.remove('text-red-500', 'text-yellow-500', 'text-indigo-500');
        } else {
            strengthBars[i].classList.add('bg-indigo-500');
            strengthText.textContent = 'Strong';
            strengthText.classList.add('text-indigo-500');
            strengthText.classList.remove('text-red-500', 'text-yellow-500', 'text-green-500');
        }
    }
}

/**
 * Show validation error message
 */
function showValidationError(inputElement, message) {
    let errorElement = inputElement.nextElementSibling;
    if (!errorElement || !errorElement.classList.contains('validation-error')) {
        errorElement = document.createElement('p');
        errorElement.classList.add('mt-2', 'text-sm', 'text-red-600', 'validation-error');
        inputElement.parentNode.insertBefore(errorElement, inputElement.nextSibling);
    }
    
    errorElement.textContent = message;
    inputElement.classList.add('border-red-500');
    
    // Focus the input with error
    inputElement.focus();
}

/**
 * Validate email format
 */
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

/**
 * Validate phone number (basic validation)
 */
function isValidPhone(phone) {
    // Allow +, digits, spaces, -, and parentheses
    const re = /^[+\d\s\-()]{7,20}$/;
    return re.test(phone);
}
