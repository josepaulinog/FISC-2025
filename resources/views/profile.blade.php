{{--
  Template Name: Profile Template
--}}

@extends('layouts.app')

@section('content')

<section class=" bg-base-200">
    <div class="container mx-auto py-16">
        <div class="flex space-x-8">
            <!-- Profile Form -->
            <div class="card bg-base-100 shadow-lg p-8 w-full">
                <h1 class="text-2xl mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Profile
                </h1>
                <form id="profile-form" class="space-y-4 form-with-loader" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="_ajax_nonce" value="{{ wp_create_nonce('update_user_profile') }}">


                    <div class="col-span-full flex items-center gap-x-8">
                        <img id="avatar-preview" src="{{ $avatar }}" alt="" class="w-32 h-32 rounded-full flex-none bg-gray-800 object-cover">
                        <div>
                            <div class="form-control">
                                <!-- Hidden file input -->
                                <input type="file" id="avatar" name="avatar" class="hidden" />

                                <!-- Styled label to mimic button -->
                                <label for="avatar" class="btn btn-outline cursor-pointer">
                                    Change avatar
                                </label>

                                <p id="file-name" class="mt-2 mb-2 text-sm text-gray-500">No file selected</p>
                            </div>
                            <p class="mt-2 text-xs leading-5 text-gray-400">JPG, GIF or PNG. 1MB max.</p>
                        </div>
                    </div>

                    <!-- Display Name Field -->
                    <div class="form-control">
                        <label class="label" for="display_name">
                            <span class="label-text">Display Name</span>
                        </label>
                        <input type="text" id="display_name" name="display_name" class="input input-bordered w-full" value="{{ $display_name }}" required>
                    </div>

                    <!-- Email Address Field -->
                    <div class="form-control">
                        <label class="label" for="user_email">
                            <span class="label-text">Email Address</span>
                        </label>
                        <input type="email" id="user_email" name="user_email" class="input input-bordered w-full" value="{{ $user_email }}" required>
                    </div>

                    <!-- Company Field -->
                    <div class="form-control">
                        <label class="label" for="company">
                            <span class="label-text">Company</span>
                        </label>
                        <input type="text" id="company" name="company" class="input input-bordered w-full" value="{{ $company }}" required>
                    </div>

                    <!-- Bio Field -->
                    <div class="form-control">
                        <label class="label" for="bio">
                            <span class="label-text">Bio</span>
                        </label>
                        <textarea id="bio" name="bio" class="textarea textarea-bordered w-full h-32" required>{{ $bio }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary text-white float-right">Update Profile</button>
                </form>
            </div>
        </div>
    </div>

    <div id="successModal" class="modal">
        <div class="modal-box bg-white shadow-lg">
            <h2 class="font-bold text-lg text-primary">Profile Updated</h2>
            <p class="py-4 text-gray-600">Your profile has been successfully updated.</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-primary text-white" id="closeModal">OK</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')