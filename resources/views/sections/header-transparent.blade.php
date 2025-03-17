<header class="fixed w-full z-20 transition-all duration-300 transparent-header">
  <div class="container mx-auto py-4 px-4">
    @if (has_nav_menu('primary_navigation'))
    <nav class="navbar px-0" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
      <label for="my-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost lg:hidden me-4 text-white header-toggle">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-6 w-6 stroke-current text-white header-icon">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </label>
      <a 
          href="{{ home_url('/') }}" 
          class="btn btn-ghost hover:bg-transparent p-0"
          aria-label="Go to homepage"
        >
          <x-logo class="lg:h-12 h-10 fill-current text-white font-normal transition-colors duration-300 header-logo" />
      </a>

      <div class="navbar-start">
      </div>
      <div class="navbar-center hidden lg:block text-white header-nav">
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

        // If no custom avatar is set, use Gravatar as fallback
        if (!$profile_avatar) {
        $profile_avatar = get_avatar_url($current_user->ID, [
        'size' => 96, // Specify the size of the Gravatar image
        'default' => 'mm', // Fallback to Gravatar's 'mystery man' if no Gravatar is available
        ]);
        }
        @endphp
        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar flex flex-col items-center">
            <div class="rounded-full">
              <img src="{{ $profile_avatar }}" alt="{{ $current_user->display_name }}'s Avatar" class="rounded-full header-avatar border">
            </div>
          </div>
          <ul tabindex="0" class="dropdown-content menu bg-base-100 p-2 rounded-box shadow-2xl bordered mt-2 z-10 ring-1 ring-black ring-opacity-5 z-20 min-w-[220px]">
            <li class="pointer-events-none">
              <div class="flex flex-col justify-start items-start"> <!-- Ensures left alignment -->
                <span class="text-sm font-medium">{{ $current_user->display_name }}</span>
                <span class="text-xs text-gray-500">{{ $current_user->user_email }}</span>
                <div class="badge badge-sm badge-primary badge-outline">{{ $primary_role }}</div>
              </div>
            </li>
            <li class="pointer-events-none">
              <hr class="my-2 border-t border-gray-200 w-full mx-auto p-0">
            </li>
            <li>
              <a href="/profile" class="justify-between">
                Profile
              </a>
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
        <a href="{{ home_url('/login') }}" class="btn btn-ghost border-white text-white hover:bg-white hover:text-black transition-colors duration-300 login-button">
          Login

          <svg class="w-3 h-3 transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"/>
          </svg>
        </a>
        @endif
      </div>
    </nav>
    @endif
  </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.transparent-header');
    const headerLogo = document.querySelector('.header-logo');
    const headerNav = document.querySelector('.header-nav');
    const headerToggle = document.querySelector('.header-toggle');
    const headerIcon = document.querySelector('.header-icon');
    const loginButton = document.querySelector('.login-button');
    
    let ticking = false;
    
    function handleScroll() {
      if (!ticking) {
        window.requestAnimationFrame(function() {
          const isScrolled = window.pageYOffset > 20;
          
          if (isScrolled) {
            // Add scrolled state classes
            header.classList.add('bg-white', 'shadow-md');
            
            if (headerLogo) {
              headerLogo.classList.remove('text-white');
              headerLogo.classList.add('text-gray-800');
            }
            
            if (headerNav) {
              headerNav.classList.remove('text-white');
              headerNav.classList.add('text-gray-800');
            }
            
            if (headerToggle) {
              headerToggle.classList.remove('text-white');
              headerToggle.classList.add('text-gray-800');
            }
            
            if (headerIcon) {
              headerIcon.classList.remove('text-white');
              headerIcon.classList.add('text-gray-800');
            }
            
            if (loginButton) {
              loginButton.classList.remove('border-white', 'text-white', 'hover:bg-white', 'hover:text-black');
              loginButton.classList.add('border-gray-800', 'text-gray-800', 'hover:bg-gray-800', 'hover:text-white');
            }
          } else {
            // Remove scrolled state classes
            header.classList.remove('bg-white', 'shadow-md');
            
            if (headerLogo) {
              headerLogo.classList.add('text-white');
              headerLogo.classList.remove('text-gray-800');
            }
            
            if (headerNav) {
              headerNav.classList.add('text-white');
              headerNav.classList.remove('text-gray-800');
            }
            
            if (headerToggle) {
              headerToggle.classList.add('text-white');
              headerToggle.classList.remove('text-gray-800');
            }
            
            if (headerIcon) {
              headerIcon.classList.add('text-white');
              headerIcon.classList.remove('text-gray-800');
            }
            
            if (loginButton) {
              loginButton.classList.add('border-white', 'text-white', 'hover:bg-white', 'hover:text-black');
              loginButton.classList.remove('border-gray-800', 'text-gray-800', 'hover:bg-gray-800', 'hover:text-white');
            }
          }
          
          ticking = false;
        });
        
        ticking = true;
      }
    }
    
    // Initialize scroll handler to set correct initial state
    handleScroll();
    
    // Add scroll event listener
    window.addEventListener('scroll', handleScroll);
  });
</script>