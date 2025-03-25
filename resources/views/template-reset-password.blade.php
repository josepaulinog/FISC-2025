{{--
  Template Name: Reset Password Template
--}}

@extends('layouts.login')

@section('content')
<div class="flex min-h-full">
    <div class="flex flex-1 flex-col justify-center px-4 py-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <a class="btn btn-ghost hover:bg-transparent p-0" href="/">
                <x-logo class="lg:h-12 h-12 fill-current dark:text-white font-normal" />
            </a>
            
            <div class="mt-8">
                <div class="mb-8">
                    @if (isset($_GET['first_login']) && $_GET['first_login'] == '1')
                        <h2 class="text-2xl tracking-tight text-gray-900">{{ __('Set Your Password', 'sage') }}</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            {{ __('For security reasons, you need to set a new password before continuing.', 'sage') }}
                        </p>
                    @else
                        <h2 class="text-2xl tracking-tight text-gray-900">{{ __('Reset Your Password', 'sage') }}</h2>
                        <p class="mt-2 text-sm text-gray-600">
                            {{ __('Enter your new password below.', 'sage') }}
                        </p>
                    @endif
                </div>

                <div class="my-4">
                    @php
                    $login = isset($_GET['login']) ? sanitize_user($_GET['login']) : '';
                    $key = isset($_GET['key']) ? sanitize_text_field($_GET['key']) : '';
                    $first_login = isset($_GET['first_login']) ? sanitize_text_field($_GET['first_login']) : '';
                    $error = isset($_GET['error']) ? $_GET['error'] : '';
                    
                    // Check if there's a key and login
                    if ($key && $login) {
                        // Check if reset key is valid
                        $user = check_password_reset_key($key, $login);
                        $key_error = is_wp_error($user);
                    } else {
                        $key_error = true;
                    }
                    @endphp
                    
                    @if ($key_error)
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 my-5 border-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ __('This password reset link is invalid or has expired. Please request a new one.', 'sage') }}</span>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ home_url('/login') }}" class="btn btn-primary w-full text-white">
                                {{ __('Back to Login') }}
                            </a>
                        </div>
                    @elseif ($error === 'password')
                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 my-5 text-white border-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ __('The passwords do not match or are empty. Please try again.', 'sage') }}</span>
                        </div>
                        
                        <form method="post" action="{{ esc_url(site_url('wp-login.php?action=resetpass')) }}" class="form-with-loader space-y-6">
                            <input type="hidden" name="key" value="{{ $key }}" />
                            <input type="hidden" name="login" value="{{ $login }}" />
                            <input type="hidden" name="first_login" value="{{ $first_login }}" />
                            
                            <div>
                                <label for="password" class="label block text-sm font-medium text-gray-700">
                                    <span class="label-text">{{ __('New Password') }} *</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="password" name="pass1" id="password" class="py-3 pl-10 pr-10 block input input-bordered w-full rounded-lg text-sm" placeholder="Enter new password" required autofocus>
                                    <button type="button" id="toggle-password-btn" class="absolute inset-y-0 right-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600 dark:text-neutral-600 dark:focus:text-blue-500">
                                        <!-- Show Icon (Initially Visible) -->
                                        <svg id="show-password-icon" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>

                                        <!-- Hide Icon (Initially Hidden) -->
                                        <svg id="hide-password-icon" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                            <line x1="2" x2="22" y1="2" y2="22"></line>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-1">
                                    <div id="password-strength-meter" class="w-full h-2 bg-gray-200 rounded-full mt-2"></div>
                                    <p id="password-strength-text" class="text-xs mt-1 text-gray-500 hidden"></p>
                                </div>
                            </div>
                            
                            <div>
                                <label for="password_confirm" class="label block text-sm font-medium text-gray-700">
                                    <span class="label-text">{{ __('Confirm New Password') }} *</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="password" name="pass2" id="password_confirm" class="py-3 pl-10 pr-10 block input input-bordered w-full rounded-lg text-sm" placeholder="Confirm new password" required>
                                    <button type="button" id="toggle-confirm-btn" class="absolute inset-y-0 right-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600 dark:text-neutral-600 dark:focus:text-blue-500">
                                        <!-- Show Icon (Initially Visible) -->
                                        <svg id="show-confirm-icon" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>

                                        <!-- Hide Icon (Initially Hidden) -->
                                        <svg id="hide-confirm-icon" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                            <line x1="2" x2="22" y1="2" y2="22"></line>
                                        </svg>
                                    </button>
                                </div>
                                <p id="password-match" class="text-xs mt-2 text-gray-500 hidden"></p>
                            </div>
                            
                            <div>
                                <button type="submit" class="btn btn-primary w-full text-white flex justify-center items-center">
                                    <span class="loading loading-spinner loading-md hidden mr-2"></span>
                                    {{ __('Save New Password') }}
                                </button>
                            </div>
                        </form>
                    @else
                        <form method="post" action="{{ esc_url(site_url('wp-login.php?action=resetpass')) }}" class="form-with-loader space-y-6">
                            <input type="hidden" name="key" value="{{ $key }}" />
                            <input type="hidden" name="login" value="{{ $login }}" />
                            <input type="hidden" name="first_login" value="{{ $first_login }}" />
                            
                            <div>
                                <label for="password" class="label block text-sm font-medium text-gray-700">
                                    <span class="label-text">{{ __('New Password') }} *</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="password" name="pass1" id="password" class="py-3 pl-10 pr-10 block input input-bordered w-full rounded-lg text-sm" placeholder="Enter new password" required autofocus>
                                    <button type="button" id="toggle-password-btn" class="absolute inset-y-0 right-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600 dark:text-neutral-600 dark:focus:text-blue-500">
                                        <!-- Show Icon (Initially Visible) -->
                                        <svg id="show-password-icon" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>

                                        <!-- Hide Icon (Initially Hidden) -->
                                        <svg id="hide-password-icon" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                            <line x1="2" x2="22" y1="2" y2="22"></line>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-1">
                                <div id="password-strength-meter" class="w-full h-2 bg-gray-200 rounded-full mt-2"></div>
                                <p id="password-strength-text" class="text-xs mt-1 text-gray-500"></p>
                                <div id="password-requirements" class="mt-2"></div>
                            </div>
                            </div>
                            
                            <div>
                                <label for="password_confirm" class="label block text-sm font-medium text-gray-700">
                                    <span class="label-text">{{ __('Confirm New Password') }} *</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="password" name="pass2" id="password_confirm" class="py-3 pl-10 pr-10 block input input-bordered w-full rounded-lg text-sm" placeholder="Confirm new password" required>
                                    <button type="button" id="toggle-confirm-btn" class="absolute inset-y-0 right-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600 dark:text-neutral-600 dark:focus:text-blue-500">
                                        <!-- Show Icon (Initially Visible) -->
                                        <svg id="show-confirm-icon" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>

                                        <!-- Hide Icon (Initially Hidden) -->
                                        <svg id="hide-confirm-icon" class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                            <line x1="2" x2="22" y1="2" y2="22"></line>
                                        </svg>
                                    </button>
                                </div>
                                <p id="password-match" class="text-xs mt-2 text-gray-500"></p>
                            </div>
                            
                            <div>
                                <button type="submit" class="btn btn-primary w-full text-white flex justify-center items-center">
                                    <span class="loading loading-spinner loading-md hidden mr-2"></span>
                                    {{ __('Save New Password') }}
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
        <img class="absolute inset-0 h-full w-full object-cover" src="https://replicate.delivery/xezq/jWh9MKFLGZ61KBEdNPT1P2TyowbN0EMHzWeJv4pmILjfSlXUA/tmp6_134lj_.jpg" alt="">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordField = document.getElementById('password');
    const confirmField = document.getElementById('password_confirm');
    const strengthMeter = document.getElementById('password-strength-meter');
    const strengthText = document.getElementById('password-strength-text');
    const passwordMatchText = document.getElementById('password-match');
    const form = document.querySelector('.form-with-loader');
    const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
    
    // Toggle password visibility
    const togglePasswordBtn = document.getElementById('toggle-password-btn');
    const showPasswordIcon = document.getElementById('show-password-icon');
    const hidePasswordIcon = document.getElementById('hide-password-icon');
    
    const toggleConfirmBtn = document.getElementById('toggle-confirm-btn');
    const showConfirmIcon = document.getElementById('show-confirm-icon');
    const hideConfirmIcon = document.getElementById('hide-confirm-icon');
    
    // Initially disable submit button if fields exist
    if (passwordField && confirmField && submitBtn) {
        submitBtn.disabled = true;
    }
    
    // Set up password toggle functionality
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                showPasswordIcon.classList.add('hidden');
                hidePasswordIcon.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                showPasswordIcon.classList.remove('hidden');
                hidePasswordIcon.classList.add('hidden');
            }
        });
    }
    
    // Set up confirm password toggle functionality
    if (toggleConfirmBtn) {
        toggleConfirmBtn.addEventListener('click', function() {
            if (confirmField.type === 'password') {
                confirmField.type = 'text';
                showConfirmIcon.classList.add('hidden');
                hideConfirmIcon.classList.remove('hidden');
            } else {
                confirmField.type = 'password';
                showConfirmIcon.classList.remove('hidden');
                hideConfirmIcon.classList.add('hidden');
            }
        });
    }
    
// Function to validate both password fields and control submit button
function validatePasswords() {
    if (!passwordField || !confirmField || !submitBtn) return;
    
    const password = passwordField.value;
    const confirmPassword = confirmField.value;
    
    // Simple requirements - just check length and match
    const isLongEnough = password.length >= 8;
    const passwordsMatch = password === confirmPassword && confirmPassword.length > 0;
    
    // Start with hidden status for feedback elements
    strengthText.textContent = '';
    strengthText.className = 'text-xs mt-1 hidden';
    passwordMatchText.textContent = '';
    passwordMatchText.className = 'text-xs mt-2 hidden';
    
    // Update password length feedback only if user has started typing
    if (password.length > 0) {
        if (isLongEnough) {
            strengthText.textContent = 'Password meets minimum length';
            strengthText.className = 'text-xs mt-2 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border-green-500';
            strengthMeter.className = 'w-full h-2 bg-success rounded-full mt-2';
        } else {
            strengthText.textContent = `Password must be at least 8 characters (${password.length}/8)`;
            strengthText.className = 'text-xs mt-2 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border-red-500';
            strengthMeter.className = 'w-full h-2 bg-error rounded-full mt-2';
        }
    } else {
        strengthMeter.className = 'w-full h-2 bg-gray-200 rounded-full mt-2';
    }
    
    // Update password match feedback only if confirm field has input
    if (confirmPassword.length > 0) {
        if (passwordsMatch) {
            passwordMatchText.textContent = 'Passwords match';
            passwordMatchText.className = 'text-xs mt-2 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border-green-500';
        } else {
            passwordMatchText.textContent = 'Passwords do not match';
            passwordMatchText.className = 'text-xs mt-2 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border-red-500';
        }
    }
    
    // Enable button only if both conditions are met
    if (isLongEnough && passwordsMatch) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('btn-disabled');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.add('btn-disabled');
    }
}
    
    // Password strength measurement
    if (passwordField) {
        passwordField.addEventListener('input', function() {
            const password = passwordField.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;
            if (password.match(/\d/)) strength += 1;
            if (password.match(/[^a-zA-Z\d]/)) strength += 1;
            
            switch (strength) {
                case 0:
                    strengthMeter.className = 'w-full h-2 bg-gray-200 rounded-full mt-2';
                    strengthText.textContent = '';
                    break;
                case 1:
                    strengthMeter.className = 'w-full h-2 bg-red-500 rounded-full mt-2';
                    strengthText.textContent = 'Weak password';
                    strengthText.className = 'text-xs mt-1 text-red-500';
                    break;
                case 2:
                    strengthMeter.className = 'w-full h-2 bg-orange-500 rounded-full mt-2';
                    strengthText.textContent = 'Fair password';
                    strengthText.className = 'text-xs mt-1 text-orange-500';
                    break;
                case 3:
                    strengthMeter.className = 'w-full h-2 bg-yellow-500 rounded-full mt-2';
                    strengthText.textContent = 'Good password';
                    strengthText.className = 'text-xs mt-1 text-yellow-600';
                    break;
                case 4:
                    strengthMeter.className = 'w-full h-2 bg-green-500 rounded-full mt-2';
                    strengthText.textContent = 'Strong password';
                    strengthText.className = 'text-xs mt-1 text-green-500';
                    break;
            }
            
            // Validate passwords after strength check
            validatePasswords();
        });
    }
    
    // Check if passwords match
    if (confirmField && passwordField) {
        confirmField.addEventListener('input', function() {
            validatePasswords();
        });
    }
    
    // Add animation to the form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            // Double-check validation before submission
            if (passwordField && confirmField) {
                if (passwordField.value !== confirmField.value) {
                    e.preventDefault();
                    passwordMatchText.textContent = 'Passwords do not match';
                    passwordMatchText.className = 'text-xs mt-1 text-red-500';
                    return false;
                }
            }
            
            const spinner = form.querySelector('.loading-spinner');
            if (spinner) {
                spinner.classList.remove('hidden');
            }
            
            if (submitBtn) {
                submitBtn.disabled = true;
            }
        });
    }
});
</script>
@endsection