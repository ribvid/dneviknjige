<div class="wrapper flow prose | fade-in-slide-up">
  @include('partials.page-header', ['title' => sprintf('%s %s', __('Leto', 'sage'), get_the_title())])

  {!! get_field('about') !!}

  @php $images = get_field('images') @endphp
  @if (!empty($images))
    @include('partials.gallery', ['images' => $images, 'fit' => 'contain'])
  @endif
</div>
