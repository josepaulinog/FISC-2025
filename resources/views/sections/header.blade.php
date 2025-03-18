<header class="bg-base-100 shadow-md">
  <div class="container mx-auto py-4 px-4 flex justify-between items-center">
    @if (has_nav_menu('primary_navigation'))
    <nav class="navbar px-0" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
      <label for="my-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost lg:hidden me-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-6 w-6 stroke-current">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </label>
      <a 
          href="{{ home_url('/') }}" 
          class="btn btn-ghost hover:bg-transparent p-0"
          aria-label="Go to homepage"
        >
          <x-logo class="lg:h-12 h-10 fill-current dark:text-white font-normal transition-colors duration-300" />
      </a>

      <div class="navbar-start">
      </div>
      <div class="navbar-center hidden lg:block">
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
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-400 d-inline hidden d-none" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
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
            <li>
              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            </li>
          </ul>
          <form id="logout-form" action="{{ wp_logout_url(home_url('/')) }}" method="POST" style="display: none;">
            <?php wp_nonce_field('log-out'); ?>
            <input type="hidden" name="action" value="logout">
            <input type="hidden" name="redirect_to" value="{{ home_url('/') }}">
          </form>
        </div>
        @else
        <a href="{{ home_url('/login') }}" class="btn btn-primary px-4 py-2 text-white">
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