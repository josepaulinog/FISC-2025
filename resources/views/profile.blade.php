{{--
  Template Name: Profile Template
--}}

@extends('layouts.app')

@section('content')
<section class="py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-4xl font-semibold text-gray-900 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Profile
                </h1>
                <p class="text-gray-600 mt-2 max-w-2xl">Get to know your fellow delegates ahead of time: share some key information in your profile and this will appear in the Attendees section</p>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white shadow-lg rounded-lg dark:bg-black/25 border border-gray-300 overflow-hidden">
            <form id="profile-form" class="form-with-loader" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_ajax_nonce" value="{{ wp_create_nonce('update_user_profile') }}">
                
                <!-- Avatar Banner Section -->
                <div class="relative bg-base-200 h-48 flex items-center justify-center">
                    <div class="absolute -bottom-16 flex flex-col items-center">
                        <div class="relative group">
                            <img id="avatar-preview" src="{{ $avatar }}" alt="" class="w-32 h-32 rounded-full border-4 border-white shadow-md bg-gray-200 object-cover">
                            <div class="absolute inset-0 rounded-full bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-200 flex items-center justify-center">
                                <input type="file" id="avatar" name="avatar" class="hidden" accept="image/png,image/jpeg,image/gif" />
                                <label for="avatar" class="absolute inset-0 cursor-pointer flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <span class="bg-white text-gray-800 px-3 py-1 rounded-full text-sm font-medium shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Change
                                    </span>
                                </label>
                            </div>
                        </div>
                        <p id="file-name" class="text-sm text-gray-500 mt-1">JPG, GIF or PNG. 1MB max.</p>
                    </div>
                </div>
                
                <!-- Form Content -->
                <div class="px-6 pt-20 pb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <!-- Display Name Field -->
                        <div class="form-control">
                            <label class="text-sm font-medium text-gray-700 mb-1" for="display_name">Display Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                                <input id="display_name" type="text" name="display_name" placeholder="Your name" 
                                    class="input input-bordered w-full pl-10 h-11 rounded-lg" 
                                    value="{{ $display_name }}" required />
                            </div>
                        </div>

                        <!-- Email Address Field -->
                        <div class="form-control">
                            <label class="text-sm font-medium text-gray-700 mb-1" for="user_email">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <input id="user_email" type="email" name="user_email" placeholder="email@example.com" 
                                    class="input input-bordered w-full pl-10 h-11 rounded-lg" 
                                    value="{{ $user_email }}" required />
                            </div>
                        </div>

                        <!-- Position Field -->
                        <div class="form-control">
                            <label class="text-sm font-medium text-gray-700 mb-1" for="job_title">Position</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                    </svg>
                                </div>
                                <input id="job_title" type="text" name="job_title" placeholder="Your Position" 
                                    class="input input-bordered w-full pl-10 h-11 rounded-lg" 
                                    value="{{ $job_title ?? '' }}" />
                            </div>
                        </div>

                        <!-- Organization Field -->
                        <div class="form-control">
                            <label class="text-sm font-medium text-gray-700 mb-1" for="company">Organization</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                    </svg>
                                </div>
                                <input id="company" type="text" name="company" placeholder="Your organization" 
                                    class="input input-bordered w-full pl-10 h-11 rounded-lg" 
                                    value="{{ $company }}" required />
                            </div>
                        </div>

                        <!-- Country Field -->
                        <div class="form-control">
                            <label class="text-sm font-medium text-gray-700 mb-1" for="country">Country</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                </div>
                                <input id="country" type="text" name="country" placeholder="Your country" 
                                    class="input input-bordered w-full pl-10 h-11 rounded-lg" 
                                    value="{{ $country ?? '' }}" />
                            </div>
                        </div>
                        
                        <!-- LinkedIn Field -->
                        <div class="form-control">
                            <label class="text-sm font-medium text-gray-700 mb-1" for="linkedin">LinkedIn Profile</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-400" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </div>
                                <input id="linkedin" type="url" name="linkedin" placeholder="https://linkedin.com/in/username" 
                                    class="input input-bordered w-full pl-10 h-11 rounded-lg" 
                                    value="{{ $linkedin ?? '' }}" />
                            </div>
                        </div>
                        
                        <!-- X.com Field -->
                        <div class="form-control">
                            <label class="text-sm font-medium text-gray-700 mb-1" for="twitter">X.com</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 text-gray-400" fill="currentColor">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </div>
                                <input id="twitter" type="url" name="twitter" placeholder="https://x.com/username" 
                                    class="input input-bordered w-full pl-10 h-11 rounded-lg" 
                                    value="{{ $twitter ?? '' }}" />
                            </div>
                        </div>
                        
                        <!-- Website -->
                        <div class="form-control">
                            <label class="text-sm font-medium text-gray-700 mb-1" for="website">Website</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                    </svg>
                                </div>
                                <input id="website" type="url" name="website" placeholder="https://example.com/" 
                                    class="input input-bordered w-full pl-10 h-11 rounded-lg" 
                                    value="{{ $website ?? '' }}" />
                            </div>
                        </div>
                    </div>

                    <!-- Bio Field - full width -->
                    <div class="form-control mt-6">
                        <label class="text-sm font-medium text-gray-700 mb-1" for="bio">Bio: Tell your fellow delegates about your role, experience and interests.</label>
                        <div class="relative">
                            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <textarea id="bio" name="bio" rows="4" 
                                class="textarea textarea-bordered w-full pl-10 py-3 rounded-lg min-h-[120px] resize-y" 
                                required>{{ $bio }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="btn btn-primary text-white px-6 py-3 rounded-lg font-medium hover:opacity-90 transition-opacity">
                            Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-box bg-white rounded-xl shadow-lg">
            <h2 class="text-xl font-bold text-primary mb-2">Profile Updated</h2>
            <p class="text-gray-600">Your profile has been successfully updated.</p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-primary text-white" id="closeModal">OK</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Profile form JS fix

document.addEventListener('DOMContentLoaded', function() {
    // Preview selected avatar image before upload
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatar-preview');
    const fileNameDisplay = document.getElementById('file-name');
    
    if (avatarInput) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = 'JPG, GIF or PNG. 1MB max.';
            }
        });
    }

    // Handle form submission
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            // Add the action parameter that WordPress requires
            formData.append('action', 'update_user_profile');
            
            // Add loading state
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.classList.add('loading');
            submitButton.disabled = true;
            
            // Make sure the ajax URL is correct
            const ajaxUrl = (window.ajaxObject && window.ajaxObject.ajax_url) 
                ? window.ajaxObject.ajax_url 
                : '/wp-admin/admin-ajax.php';
            
            fetch(ajaxUrl, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                submitButton.classList.remove('loading');
                submitButton.disabled = false;
                
                if (data.success) {
                    // Show success modal
                    const successModal = document.getElementById('successModal');
                    if (successModal && typeof successModal.showModal === 'function') {
                        successModal.showModal();
                    } 
                } else {
                    // Show error
                    alert('Error: ' + (data.data || 'Something went wrong. Please try again.'));
                }
            })
            .catch(error => {
                console.error('Form submission error:', error);
                submitButton.classList.remove('loading');
                submitButton.disabled = false;
                alert('Error: ' + error.message);
            });
        });
    }
});
</script>
@endsection

@push('scripts')