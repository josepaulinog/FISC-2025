<!doctype html>
<html data-theme="light" @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())
    @include('partials.favicon')
  </head>

  <body @php(body_class())>
    <x-loader-overlay />
    @php(wp_body_open())

    <div class="drawer">
      <input id="my-drawer" type="checkbox" class="drawer-toggle" />
      <div class="drawer-content">
        <!-- Page content here -->
        <div id="app">
          <a class="sr-only focus:not-sr-only" href="#main">
            {{ __('Skip to content', 'sage') }}
          </a>

          @if(is_front_page() || !is_user_logged_in())
            @include('sections.header-transparent')
          @else
            @include('sections.header')
          @endif

          <main id="main" class="main">
            @yield('content')
          </main>

          @hasSection('sidebar')
            <aside class="sidebar hidden">
              @yield('sidebar')
            </aside>
          @endif

          @include('sections.footer')
        </div>
      </div>
      @include('partials.mobile-drawer')
    </div>
    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>