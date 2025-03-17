<header class="fixed w-full z-20 transition-all duration-300 js-transparent-header">
  <div class="container mx-auto py-4 px-4">
    @if (has_nav_menu('primary_navigation'))
    <nav class="navbar px-0" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
        <label 
          for="my-drawer" 
          class="btn btn-square btn-ghost lg:hidden me-5 js-header-toggle"
          aria-label="open sidebar"
        >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-6 w-6 stroke-current text-white js-header-icon">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </label>

      <a 
          href="{{ home_url('/') }}" 
          class="btn btn-ghost hover:bg-transparent p-0"
          aria-label="Go to homepage"
        >
        <x-logo 
              class="lg:h-12 h-10 fill-current transition-colors duration-300 font-normal text-white js-header-logo"
       />
      </a>

      <div class="navbar-start">
      </div>
      <div 
            class="navbar-center hidden lg:flex text-white js-header-nav"
          >
            @if (is_user_logged_in())
              {!! $navigation !!}
            @endif
          </div>
      <div class="navbar-end">
        @if (is_user_logged_in())
        @php
        $current_user = wp_get_current_user();
        $profile_avatar = get_user_meta($current_user->ID, 'profile_avatar', true);
        $user_roles = $current_user->roles;
        $primary_role = ucfirst(str_replace('_', ' ', $user_roles[0]));

        if (!$profile_avatar) {
          $profile_avatar = get_avatar_url($current_user->ID, [
            'size' => 96,
            'default' => 'mm',
          ]);
        }
        @endphp
        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar flex flex-col items-center">
            <div class="rounded-full">
              <img src="{{ $profile_avatar }}" alt="{{ $current_user->display_name }}'s Avatar" class="rounded-full header-avatar">
            </div>
          </div>
          <ul tabindex="0" class="dropdown-content menu bg-base-100 p-2 rounded-box shadow-2xl bordered mt-2 z-10 ring-1 ring-black ring-opacity-5 min-w-[220px]">
            <li class="pointer-events-none">
              <div class="flex flex-col justify-start items-start">
                <span class="text-sm font-medium">{{ $current_user->display_name }}</span>
                <span class="text-xs text-gray-500">{{ $current_user->user_email }}</span>
                <div class="badge badge-sm badge-primary badge-outline">{{ $primary_role }}</div>
              </div>
            </li>
            <li class="pointer-events-none">
              <hr class="my-2 border-t border-gray-200 w-full mx-auto p-0">
            </li>
            <li>
              <a href="/profile" class="justify-between">Profile</a>
            </li>
            @if(current_user_can('administrator'))
            <li><a href="/wp-admin">WP Settings</a></li>
            @endif
            <li>
              <div class="flex items-center justify-between px-4 py-2">
                <span>Dark mode</span>
                <x-theme-toggle />
              </div>
            </li>
            <li class="pointer-events-none">
              <hr class="my-2 border-t border-gray-200 w-full mx-auto p-0">
            </li>
            <li><a href="{{ wp_logout_url(home_url('/')) }}">Logout</a></li>
          </ul>
        </div>
        @else
        <a 
                href="{{ home_url('/login') }}" 
                class="btn btn-ghost border-white text-white hover:bg-white hover:text-black transition-colors duration-300 js-login-button"
              >
                Login

                <svg class="w-3 h-3 transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
                </svg>
          </a>
        @endif
      </div>
    </nav>
    @endif
  </div><!-- Close container -->
</header>

<script>
  // Add this script to your footer or in a script file
  document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.js-transparent-header');
    const logo = document.querySelector('.js-header-logo');
    const nav = document.querySelector('.js-header-nav');
    const toggleBtn = document.querySelector('.js-header-toggle');
    const icon = document.querySelector('.js-header-icon');
    const loginBtn = document.querySelector('.js-login-button');
    
    function handleScroll() {
      if (window.pageYOffset > 20) {
        // Scrolled state
        header.classList.add('bg-white', 'shadow-md');
        header.classList.remove('bg-transparent');
        
        logo.classList.add('text-gray-800');
        logo.classList.remove('text-white');
        
        if (nav) {
          nav.classList.add('text-gray-800');
          nav.classList.remove('text-white');
        }
        
        if (toggleBtn) {
          toggleBtn.classList.add('text-gray-800');
          toggleBtn.classList.remove('text-white');
        }
        
        if (icon) {
          icon.classList.add('text-gray-800');
          icon.classList.remove('text-white');
        }
        
        if (loginBtn) {
          loginBtn.classList.add('border-gray-800', 'text-gray-800', 'hover:bg-gray-800', 'hover:text-white');
          loginBtn.classList.remove('border-white', 'text-white', 'hover:bg-white', 'hover:text-black');
        }
      } else {
        // Transparent state
        header.classList.remove('bg-white', 'shadow-md');
        header.classList.add('bg-transparent');
        
        logo.classList.remove('text-gray-800');
        logo.classList.add('text-white');
        
        if (nav) {
          nav.classList.remove('text-gray-800');
          nav.classList.add('text-white');
        }
        
        if (toggleBtn) {
          toggleBtn.classList.remove('text-gray-800');
          toggleBtn.classList.add('text-white');
        }
        
        if (icon) {
          icon.classList.remove('text-gray-800');
          icon.classList.add('text-white');
        }
        
        if (loginBtn) {
          loginBtn.classList.remove('border-gray-800', 'text-gray-800', 'hover:bg-gray-800', 'hover:text-white');
          loginBtn.classList.add('border-white', 'text-white', 'hover:bg-white', 'hover:text-black');
        }
      }
    }
    
    // Initial call to set the correct state
    handleScroll();
    
    // Add scroll event listener
    window.addEventListener('scroll', handleScroll);
  });
</script>