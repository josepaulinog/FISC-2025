<div x-data="{ isScrolled: false }" 
     x-init="window.addEventListener('scroll', () => isScrolled = window.pageYOffset > 20)">
  <header 
    x-bind:class="isScrolled ? 'bg-white shadow-md' : 'bg-transparent'"
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
                class="lg:h-12 h-10 fill-current transition-colors duration-300 font-normal"
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
      </nav>
      @endif
    </div><!-- Close container -->
  </header>
</div><!-- Close outer x-data -->
