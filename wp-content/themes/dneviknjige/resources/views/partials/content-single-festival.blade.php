<div class="wrapper mb-m fade-in-slide-up" data-element="breadcrumbs">
  <a href="{{ get_post_type_archive_link('festival') }}" class="breadcrumb-link">
    {{ __('Arhiv', 'sage') }}
  </a>
</div>

@php
  $has_no_programme = get_field('programme_not_published');
@endphp

@if ($has_no_programme)
  @include('partials.festival-without-programme')
@else
  @include('partials.programme', [
    'festivalId' => get_the_ID(),
    'heading' => sprintf('%s %s', __('Leto', 'sage'), get_the_title()),
  ])
@endif
