{{--
  Template Name: Login Template
--}}

@extends('layouts.login')

@section('content')
<div class="flex min-h-full">
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">

            <div>
                <img class="h-12 w-auto" src="{{ get_theme_file_uri('resources/images/logo.svg') }}" alt="{{ get_bloginfo('name') }}">
            </div>

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
                <h2 class="text-2xl leading-9 tracking-tight text-gray-900">{{ __('Login to your Fisc account', 'sage') }}</h2>

                <div class="my-4">
                    @if (isset($_GET['login']) && $_GET['login'] == 'failed')
                    <div class="alert alert-error my-5 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ __('Incorrect username or password. Please try again.', 'sage') }}</span>
                    </div>
                    @endif

                    <form method="post" action="{{ esc_url(site_url('wp-login.php', 'login_post')) }}" class="form-with-loader space-y-6">
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ home_url() }}" />
                        <div>
                            <label for="user_login" class="label block text-sm font-medium text-gray-700"><span class="label-text">{{ __('Username') }} *</span></label>
                            <input type="text" name="log" id="user_login" class="py-3 ps-4 pe-10 block input input-bordered w-full rounded-lg text-sm" placeholder="Username" required autofocus>
                        </div>
                        <div>
                            <label for="user_pass" class="block text-sm mb-2 dark:text-white">{{ __('Password') }}  *</label>
                            <div class="relative">
                                <input id="toggle-password" type="password" name="pwd" class="py-3 ps-4 pe-10 block input input-bordered w-full rounded-lg text-sm" placeholder="Enter password" required autocomplete>

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
                            <a href="{{ esc_url(wp_lostpassword_url()) }}" class="text-sm text-primary underline">{{ __('Forgot password?') }}</a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-full text-white flex justify-center items-center">
                                <span class="loading loading-spinner loading-md hidden mr-2"></span>
                                {{ __('Log In') }}
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
        <img class="absolute inset-0 h-full w-full object-cover" src="https://cdn.midjourney.com/fe8838c4-1aac-4611-98d7-ba3a8ac53a5b/0_3.png" alt="">
    </div>
</div>

<!-- Modal structure using dialog element -->
<dialog id="helpModal" class="modal">
    <div class="modal-box bg-white shadow-lg rounded-lg">

        <!-- Header Section with Icon -->
        <div class="flex items-center space-x-4 text-center">
            <img class="w-12 h-12 rounded-full ms-4 hidden d-none" src="https://via.placeholder.com/50" alt="User Icon">
            <div class="flex-1">
                <h2 class="font-semibold text-2xl text-gray-900 mb-4">We’re happy to help.</h2>
                <p class="text-sm text-gray-500">Get in touch using any of the mediums below.</p>
            </div>
        </div>

               <!-- Close Button -->
        <form method="dialog" class="absolute right-2 top-2">
            <button class="btn btn-sm btn-circle btn-ghost border-0">✕</button>
        </form>

<!-- Contact Details Section with Two Columns -->
        <div class="text-center w-full justify-between m-5 mx-auto">
            <!-- Email Contact -->
            <div class="inline me-4 text-center">
                <svg class="inline h-6 w-6 text-primary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#f97316" d="M64 112c-8.8 0-16 7.2-16 16l0 22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1l0-22.1c0-8.8-7.2-16-16-16L64 112zM48 212.2L48 384c0 8.8 7.2 16 16 16l384 0c8.8 0 16-7.2 16-16l0-171.8L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64l384 0c35.3 0 64 28.7 64 64l0 256c0 35.3-28.7 64-64 64L64 448c-35.3 0-64-28.7-64-64L0 128z"/></svg>

                <a href="mailto:info@freebalance.com" class="text-gray-800 text-sm ">marketing@freebalance.com</a>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 flex space-x-2 justify-center">
            <button class="px-20 btn btn-primary text-white bg-orange-500 hover:bg-orange-600">Email</button>
            <button class="px-20 btn btn-outline border-gray-300 text-gray-800 hover:bg-gray-100">Call</button>
        </div>
    </div>

    <!-- Backdrop for Click Outside to Close -->
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

@endsection

