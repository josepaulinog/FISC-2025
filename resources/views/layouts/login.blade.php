<!doctype html>
<html class="h-full bg-white" data-theme="light" @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())
    @include('partials.favicon')
  </head>

  <body @php(body_class('h-full'))>
    <x-loader-overlay />
    @php(wp_body_open())

    @yield('content')

    @php(do_action('get_footer'))
    @php(wp_footer())
  </body>
</html>
