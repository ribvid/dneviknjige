<div class="wrapper mb-m fade-in-slide-up" data-element="breadcrumbs">
  <a href="{{ get_post_type_archive_link('festival') }}"
     class="font-sans text-step-00 font-medium no-underline text-dark-gray">
    {{ __('Arhiv', 'sage') }}
  </a>
</div>

@include('partials.programme', [
  'festivalId' => get_the_ID(),
  'heading' => sprintf('%s %s', __('Leto', 'sage'), get_the_title()),
])
