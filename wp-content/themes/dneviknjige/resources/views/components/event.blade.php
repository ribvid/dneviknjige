@props([
  'heading',
  'variant' => '',
  'subheading' => null,
  'description' => null,
  'gallery' => null,
])

<article class="event | prose flow" data-variant="{{ $variant }}">
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

  @if ($gallery)
    @php $gallery_id = uniqid() @endphp
    <ul class="lightbox-gallery | grid" role="list">
      @foreach ($gallery as $i => $image_id)
        <li>
          <a href="{{ wp_get_attachment_url($image_id) }}"
             data-element="lightbox"
             data-group="post-{{ $gallery_id }}">
            {!! wp_get_attachment_image($image_id, 'medium', false, ['data-caption' => wp_get_attachment_caption($image_id)]) !!}
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</article>
