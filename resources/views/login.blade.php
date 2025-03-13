{{--
  Template Name: Login Template
--}}

@extends('layouts.login')

@section('content')
<div class="flex min-h-full">
    <div class="flex flex-1 flex-col justify-center px-4 py-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">

            <a class="btn btn-ghost hover:bg-transparent p-0" href="/">
                <x-logo class="lg:h-12 h-8 fill-current dark:text-white font-normal" />
            </a>
            <div class="mt-8">
                @if (is_user_logged_in())
                @php $current_user = wp_get_current_user(); @endphp
                <div class="card bg-base-100 shadow-lg p-6 text-center space-y-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Welcome back, {{ $current_user->display_name }}!</h2>
                    <p class="text-gray-700">You are already logged in. Explore more options below.</p>

                    <div class="space-y-4">
                        <a href="{{ home_url('/dashboard') }}" class="btn btn-primary w-full text-white">Go to Dashboard</a>
                        <a href="{{ wp_logout_url(home_url('/')) }}" class="btn btn-outline w-full">Logout</a>
                    </div>
                </div>
                @else
                <div class="mb-8">
                    <h2 class="text-2xl tracking-tight text-gray-900">{{ __('Login to your Fisc account', 'sage') }}</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Access your dashboard to manage your account.
                    </p>
                </div>

                <div class="my-4">
                    @if (isset($_GET['login']) && $_GET['login'] == 'failed')
                    <div class="alert alert-error my-5 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Incorrect username or password. Please try again.', 'sage') }}</span>
                    </div>
                    @endif

                    @if (isset($_GET['login_required']) && $_GET['login_required'] == 'true')
                    <div class="alert alert-warning my-5 flex items-center p-4 bg-amber-50 border-l-4 border-amber-500 rounded-md">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-amber-800">{{ __('Access Restricted', 'sage') }}</h3>
                            <p class="text-amber-700 text-sm mt-1">{{ __('You must log in to access the requested page.', 'sage') }}</p>
                        </div>
                    </div>
                    @endif

                    <form method="post" action="{{ esc_url(site_url('wp-login.php', 'login_post')) }}" class="form-with-loader space-y-6">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ home_url() }}" />
                        <div>
                            <label for="user_login" class="label block text-sm font-medium text-gray-700"><span class="label-text">{{ __('Username') }} *</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="log" id="user_login" class="py-3 pl-10 pr-4 block input input-bordered w-full rounded-lg text-sm" placeholder="Username" required autofocus>
                            </div>
                        </div>
                        <div>
                            <label for="user_pass" class="block text-sm mb-2 dark:text-white">{{ __('Password') }} *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="password-field" type="password" name="pwd" class="py-3 pl-10 pr-10 block input input-bordered w-full rounded-lg text-sm" placeholder="Enter password" required autocomplete>

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
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="rememberme" class="checkbox border-gray-400 [--chkbg:#5db85b] [--chkfg:#fff]" value="forever"
                                    {{ isset($_POST['rememberme']) ? 'checked' : '' }}>
                                <span class="ml-2">{{ __('Remember me') }}</span>
                            </label>
                            <button type="button" onclick="passwordRecoveryModal.showModal()" class="text-sm text-primary underline">{{ __('Forgot password?') }}</button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-full text-white flex justify-center items-center">
                                <span class="loading loading-spinner loading-md hidden mr-2"></span>
                                {{ __('Login') }}

                                <svg class="w-3 h-3 text-white transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"></path>
                                </svg>

                            </button>
                            <div class="text-center mt-4 hidden">
                                <span class="text-primary underline text-sm cursor-pointer" onclick="helpModal.showModal()">Need help in Login?</span>
                            </div>

                        </div>
                        @php do_action('login_form_bottom') @endphp
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
        <img class="absolute inset-0 h-full w-full object-cover" src="https://replicate.delivery/xezq/jWh9MKFLGZ61KBEdNPT1P2TyowbN0EMHzWeJv4pmILjfSlXUA/tmp6_134lj_.jpg" alt="">
        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>
</div>

<!-- Help Modal -->
<dialog id="helpModal" class="modal">
    <div class="modal-box bg-white shadow-lg rounded-lg">

        <!-- Header Section with Icon -->
        <div class="flex items-center space-x-4 text-center">
            <img class="w-12 h-12 rounded-full ms-4 hidden d-none" src="https://via.placeholder.com/50" alt="User Icon">
            <div class="flex-1">
                <h2 class="font-semibold text-2xl text-gray-900 mb-4">We're happy to help.</h2>
                <p class="text-sm text-gray-500">Get in touch using any of the mediums below.</p>
            </div>
        </div>

        <!-- Close Button -->
        <form method="dialog" class="absolute right-2 top-2">
            <button type="button" class="btn btn-sm btn-circle btn-ghost border-0">✕</button>
        </form>

        <!-- Contact Details Section with Two Columns -->
        <div class="text-center w-full justify-between m-5 mx-auto">
            <!-- Email Contact -->
            <div class="inline me-4 text-center">
                <svg class="inline h-6 w-6 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="#f97316" d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z" />
                </svg>

                <a href="mailto:marketing@freebalance.com" class="text-gray-800 text-sm">marketing@freebalance.com</a>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 flex space-x-2 justify-center">
            <button class="px-20 btn btn-primary text-white bg-orange-500 hover:bg-orange-600">Email</button>
            <button class="px-20 btn btn-outline border-gray-300 text-gray-800 hover:bg-gray-100">Call</button>
        </div>
    </div>

    <!-- Backdrop for Click Outside to Close -->
    <div class="modal-backdrop" onclick="passwordRecoveryModal.close()"></div>
</dialog>

<!-- Password Recovery Modal -->
<dialog id="passwordRecoveryModal" class="modal">
    <div class="modal-box bg-white shadow-lg rounded-lg max-w-md">
        <!-- Header Section -->
        <div class="text-center mb-6">
            <h2 class="font-semibold text-2xl text-gray-900">Reset Your Password</h2>
            <p class="text-sm text-gray-500 mt-2">Enter your email address and we'll send you instructions to reset your password.</p>
        </div>

        <!-- Close Button -->
        <div class="absolute right-2 top-2">
            <button type="button" onclick="passwordRecoveryModal.close()" class="btn btn-sm btn-circle btn-ghost border-0">✕</button>
        </div>

        <!-- Password Recovery Form -->
        <form method="post" action="{{ esc_url(wp_lostpassword_url()) }}" class="form-with-loader space-y-6">
            @csrf
            <div>
                <label for="user_email" class="label block text-sm font-medium text-gray-700">
                    <span class="label-text">{{ __('Email Address') }} *</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <input type="email" name="user_login" id="user_email" class="py-3 pl-10 pr-4 block input input-bordered w-full rounded-lg text-sm"
                        placeholder="Enter your email address" required>
                </div>
                <p class="text-xs text-gray-500 mt-2">We'll send a password reset link to this email address.</p>
            </div>

            <div id="recovery-message" class="alert alert-success hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Check your email for the password reset link.</span>
            </div>

            <div class="mt-6">
                <button type="submit" id="recovery-submit" class="btn btn-primary w-full text-white">
                    <span class="loading loading-spinner loading-md hidden mr-2"></span>
                    {{ __('Send Reset Link') }}
                </button>
            </div>
        </form>

        <!-- Divider -->
        <div class="divider my-6">OR</div>

        <!-- Back to Login Button -->
        <div class="text-center">
            <button class="btn btn-outline w-full" onclick="passwordRecoveryModal.close()">
                {{ __('Back to Login') }}
            </button>
        </div>
    </div>

    <!-- Backdrop for Click Outside to Close -->
    <div class="modal-backdrop" onclick="helpModal.close()"></div>
</dialog>

<!-- Add JavaScript for Password Recovery Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePasswordBtn = document.getElementById('toggle-password-btn');
        const passwordField = document.getElementById('password-field');
        const showIcon = document.getElementById('show-password-icon');
        const hideIcon = document.getElementById('hide-password-icon');

        if (togglePasswordBtn && passwordField) {
            togglePasswordBtn.addEventListener('click', function() {
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    showIcon.classList.add('hidden');
                    hideIcon.classList.remove('hidden');
                } else {
                    passwordField.type = 'password';
                    showIcon.classList.remove('hidden');
                    hideIcon.classList.add('hidden');
                }
            });
        }

        // Handle password recovery form submission
        const recoveryForm = document.querySelector('#passwordRecoveryModal form');
        const recoverySubmit = document.getElementById('recovery-submit');
        const recoveryMessage = document.getElementById('recovery-message');

        if (recoveryForm) {
            recoveryForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading spinner
                const spinner = recoverySubmit.querySelector('.loading');
                spinner.classList.remove('hidden');
                recoverySubmit.disabled = true;

                // Get the email value
                const email = document.getElementById('user_email').value;

                // Submit the form via AJAX
                fetch(recoveryForm.action, {
                        method: 'POST',
                        body: new FormData(recoveryForm),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        // Show success message (even if not found, for security)
                        recoveryMessage.classList.remove('hidden');
                        // Hide form fields
                        document.getElementById('user_email').parentElement.classList.add('hidden');
                        recoverySubmit.classList.add('hidden');
                    })
                    .catch(error => {
                        // Still show success for security (don't reveal if email exists)
                        recoveryMessage.classList.remove('hidden');
                        document.getElementById('user_email').parentElement.classList.add('hidden');
                        recoverySubmit.classList.add('hidden');
                    })
                    .finally(() => {
                        // Hide loading spinner
                        spinner.classList.add('hidden');
                    });
            });
        }
    });
</script>

@endsection