<div x-data="{ isScrolled: false }" 
     x-init="window.addEventListener('scroll', () => isScrolled = window.pageYOffset > 20)">
  <header 
    x-bind:class="isScrolled ? 'bg-white shadow-md' : 'bg-transparent backdrop-blur-lg'"
    class="fixed w-full z-20 transition-all duration-300"
  >
    <div class="container mx-auto py-4 px-4">
      @if (has_nav_menu('primary_navigation'))
      <nav class="navbar px-0" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
          <label 
            for="my-drawer" 
            class="btn btn-square btn-ghost lg:hidden me-5"
            :class="{ 'text-gray-800': isScrolled, 'text-white': !isScrolled }"
            aria-label="open sidebar"
          >
          <svg :class="{ 'text-gray-800': isScrolled, 'text-white': !isScrolled }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-6 w-6 stroke-current text-white">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </label>

        <a 
            href="{{ home_url('/') }}" 
            class="btn btn-ghost hover:bg-transparent p-0"
            aria-label="Go to homepage"
          >
          <x-logo 
                class="lg:h-12 h-9 fill-current transition-colors duration-300 font-normal"
                x-bind:class="isScrolled ? 'text-gray-800' : 'text-white'"
         />
        </a>

        <div class="navbar-start">
        </div>
        <div 
              class="navbar-center hidden lg:flex"
              x-bind:class="isScrolled ? 'text-gray-800' : 'text-white'"
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
            <div tabindex="1" role="button" class="btn btn-ghost btn-circle avatar flex flex-col items-center">
              <div class="rounded-full">
                <img src="{{ $profile_avatar }}" alt="{{ $current_user->display_name }}'s Avatar" class="rounded-full header-avatar">
              </div>
            </div>
            <ul tabindex="1" class="dropdown-content menu bg-base-100 p-2 rounded-box shadow-2xl bordered mt-2 z-10 ring-1 ring-black ring-opacity-5">
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
              <li><a href="{{ wp_logout_url(home_url('/')) . '&_wpnonce=' . wp_create_nonce('log-out') }}">Logout</a></li>
            </ul>
          </div>
          @else
          <a 
                  href="{{ home_url('/login') }}" 
                  class="btn btn-ghost transition-colors duration-300"
                  x-bind:class="isScrolled ? 'border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white' : 'border-white text-white hover:bg-white hover:text-black'"
                >
                  Login
            </a>
          @endif
        </div>
      </nav>
      @endif
    </div><!-- Close container -->
  </header>
</div><!-- Close outer x-data -->
