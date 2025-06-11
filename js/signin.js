class AuthSystem {
    constructor() {
        this.currentPage = 'signin';
        this.users = JSON.parse(localStorage.getItem('easyfly_users') || '[]');
        this.currentUser = null;
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        const signUpBtnLink = document.querySelector('.signUpBtn-link');
        const signInBtnLink = document.querySelector('.signInBtn-link');
        const wrapper = document.querySelector('.wrapper');

        signUpBtnLink.addEventListener('click', (e) => {
            e.preventDefault();
            wrapper.classList.add('active');
            wrapper.classList.remove('details-active');
        });

        signInBtnLink.addEventListener('click', (e) => {
            e.preventDefault();
            wrapper.classList.remove('active');
            wrapper.classList.remove('details-active');
        });

        // Form submissions
        document.getElementById('signin-form').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSignIn();
        });

        document.getElementById('signup-form').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleSignUp();
        });

        document.getElementById('details-form').addEventListener('submit', (e) => {
            e.preventDefault();
            this.handleDetailsSubmission();
        });

        // Password strength checker
        document.getElementById('signup-password').addEventListener('input', (e) => {
            this.checkPasswordStrength(e.target.value);
        });

        // Confirm password validation
        document.getElementById('confirm-password').addEventListener('input', (e) => {
            this.validatePasswordMatch();
        });
    }

    showDetailsPage() {
        const wrapper = document.querySelector('.wrapper');
        wrapper.classList.add('details-active');
        wrapper.classList.remove('active');

        wrapper.style.height = '650px';
    }

    handleSignIn() {
        const username = document.getElementById('signin-username').value;
        const password = document.getElementById('signin-password').value;

        if (!username || !password) {
            this.showError('Please fill in all fields', 'signin-form');
            return;
        }

        // Check if user exists
        const user = this.users.find(u => u.username === username && u.password === password);
        
        if (user) {
            this.currentUser = user;
            if (user.profileComplete) {
                this.showSuccess('Sign in successful!', 'signin-form');
            } else {
                this.showDetailsPage();
            }
        } else {
            this.showError('Invalid username or password', 'signin-form');
        }
    }

    handleSignUp() {
        const passportNumber = document.getElementById('passport-number').value;
        const username = document.getElementById('signup-username').value;
        const password = document.getElementById('signup-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (!passportNumber || !username || !password || !confirmPassword) {
            this.showError('Please fill in all fields', 'signup-form');
            return;
        }

        if (password !== confirmPassword) {
            this.showError('Passwords do not match', 'signup-form');
            return;
        }

        if (password.length < 6) {
            this.showError('Password must be at least 6 characters long', 'signup-form');
            return;
        }

        // Check if username already exists
        if (this.users.find(u => u.username === username)) {
            this.showError('Username already exists', 'signup-form');
            return;
        }

        // Create new user
        const newUser = {
            id: Date.now(),
            passportNumber,
            username,
            password,
            profileComplete: false,
            createdAt: new Date().toISOString()
        };

        this.users.push(newUser);
        this.saveUsers();
        this.currentUser = newUser;
        
        this.showSuccess('Account created successfully!', 'signup-form');
        setTimeout(() => {
            this.showDetailsPage();
        }, 1500);
    }

    handleDetailsSubmission() {
        const firstName = document.getElementById('first-name').value;
        const lastName = document.getElementById('last-name').value;
        const email = document.getElementById('email').value;
        const telephone = document.getElementById('telephone').value;
        const address = document.getElementById('address').value;
        const postalCode = document.getElementById('postal-code').value;
        const city = document.getElementById('city').value;
        const country = document.getElementById('country').value;

        if (!firstName || !lastName || !email || !telephone || !address || !postalCode || !city || !country) {
            this.showError('Please fill in all fields', 'details-form');
            return;
        }

        if (!this.isValidEmail(email)) {
            this.showError('Please enter a valid email address', 'details-form');
            return;
        }

        // Update user profile
        this.currentUser.firstName = firstName;
        this.currentUser.lastName = lastName;
        this.currentUser.email = email;
        this.currentUser.telephone = telephone;
        this.currentUser.address = address;
        this.currentUser.postalCode = postalCode;
        this.currentUser.city = city;
        this.currentUser.country = country;
        this.currentUser.profileComplete = true;

        // Update in users array
        const userIndex = this.users.findIndex(u => u.id === this.currentUser.id);
        if (userIndex !== -1) {
            this.users[userIndex] = this.currentUser;
            this.saveUsers();
        }

        this.showSuccess('Registration completed successfully!', 'details-form');
        
        // Show the proceed button
        document.getElementById('proceed-btn').style.display = 'block';
    }

    checkPasswordStrength(password) {
        let strength = 0;
        let strengthText = 'Weak';

        if (password.length >= 6) strength += 25;
        if (password.length >= 10) strength += 25;
        if (/[A-Z]/.test(password)) strength += 25;
        if (/[0-9]/.test(password)) strength += 25;

        if (strength >= 75) strengthText = 'Strong';
        else if (strength >= 50) strengthText = 'Medium';

        this.updatePasswordStrength(strength, strengthText);
    }

    updatePasswordStrength(strength, text) {
        const strengthFill = document.querySelector('.strength-fill');
        const strengthText = document.querySelector('.strength-text');

        strengthFill.style.width = `${strength}%`;
        strengthText.textContent = `Password strength: ${text}`;

        if (strength >= 75) {
            strengthFill.style.background = '#27ae60';
        } else if (strength >= 50) {
            strengthFill.style.background = '#f39c12';
        } else {
            strengthFill.style.background = '#e74c3c';
        }
    }

    validatePasswordMatch() {
        const password = document.getElementById('signup-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const confirmInput = document.getElementById('confirm-password');

        if (confirmPassword && password !== confirmPassword) {
            confirmInput.style.borderBottom = '2px solid #e74c3c';
        } else {
            confirmInput.style.borderBottom = '2px solid #e4e4e4';
        }
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    showError(message, formId) {
        this.removeMessages(formId);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        
        const form = document.getElementById(formId);
        form.insertBefore(errorDiv, form.firstChild);

        setTimeout(() => {
            if (errorDiv.parentNode) {
                errorDiv.remove();
            }
        }, 5000);
    }

    showSuccess(message, formId) {
        this.removeMessages(formId);
        
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.textContent = message;
        
        const form = document.getElementById(formId);
        form.insertBefore(successDiv, form.firstChild);

        setTimeout(() => {
            if (successDiv.parentNode) {
                successDiv.remove();
            }
        }, 3000);
    }

    removeMessages(formId) {
        const form = document.getElementById(formId);
        const existingMessages = form.querySelectorAll('.error-message, .success-message');
        existingMessages.forEach(msg => msg.remove());
    }

    saveUsers() {
        localStorage.setItem('easyfly_users', JSON.stringify(this.users));
    }
}

// Initialize the authentication system
const authSystem = new AuthSystem();
