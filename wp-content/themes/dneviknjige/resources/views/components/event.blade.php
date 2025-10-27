@props([
  'heading',
  'variant' => '',
  'subheading' => null,
  'description' => null,
  'gallery' => null,
])

<div class="event | flow" data-variant="{{ $variant }}">
  <article class="prose flow">
    <header class="flow">
      <h2 class="event__heading">{!! $heading !!}</h2>
      @if ($subheading)
        <p class="event__subheading | flow-space-2xs">
          {!! $subheading !!}
        </p>
      @endif
    </header>
    @if ($description)
      <div>{!! $description !!}</div>
    @endif
  </article>

  @if ($gallery)
    <ul class="lightbox-gallery cluster" role="list">
      @foreach ($gallery as $image_id)
        <li>
          <a href="{{ wp_get_attachment_url($image_id) }}"
             class="lightbox"
             data-element="lightbox"
             data-group="post-{{ $post_id }}-{{ get_row_index() }}">
            {!! wp_get_attachment_image($image_id, 'medium', false, ['data-caption' => wp_get_attachment_caption($image_id)]) !!}
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</div>
