<!doctype html>
<html @php language_attributes() @endphp>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php do_action('get_header') @endphp
  @php wp_head() @endphp

  {{-- Only including 'resources/js/app.js' in Vite directive since app.css is already imported through app.js via import.meta.glob --}}
  @vite(['resources/js/app.js'])
</head>

@php $active_festival = get_field('active_festival', 'options') @endphp

<body @php body_class($active_festival ? "has-active-festival" : "") @endphp>
@php wp_body_open() @endphp

<div id="app">
  <a class="sr-only focus:not-sr-only" href="#main">
    {{ __('Skip to content', 'sage') }}
  </a>

  @include('sections.site-head')

  <main id="main" class="main">
    @yield('content')
  </main>

  @unless(is_front_page())
    @include('sections.site-footer')
  @endunless
</div>

@php do_action('get_footer') @endphp
@php wp_footer() @endphp
</body>
</html>
