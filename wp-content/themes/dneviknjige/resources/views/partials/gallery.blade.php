<figure class="gallery" data-element="gallery">
  @foreach ($images as $image_id)
    {!! wp_get_attachment_image($image_id, 'large') !!}
  @endforeach
</figure>
