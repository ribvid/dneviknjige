@extends('layouts.app')

@section('content')
  @while(have_posts())
    @php the_post() @endphp
    @php $gallery = get_field('gallery') @endphp
    @php $has_gallery = $gallery && !empty($gallery['images']) @endphp

    <div class="flow fade-in-slide-up">
      <div class="prose wrapper flow">
        @include('partials.page-header')
        @if ($has_gallery && $gallery['position'] === 'start')
          @include('partials.gallery', ['images' => $gallery['images']])
        @endif
        @includeFirst(['partials.content-page', 'partials.content'])
        @if ($has_gallery && $gallery['position'] === 'end')
          @include('partials.gallery', ['images' => $gallery['images']])
        @endif
      </div>

      @if (have_rows('supporters'))
        <div class="wrapper flow-space-l-2xl">
          <div class="supporters flow flow-space-m">
            <h2 class="text-step-00 font-regular text-dark-gray">{{ __('Podporniki festivala', 'sage') }}</h2>
            <div class="cluster">
              @while (have_rows('supporters'))
                @php the_row() @endphp
                {!! wp_get_attachment_image(get_sub_field('logo'), 'large') !!}
              @endwhile
            </div>
          </div>
        </div>
      @endif
    </div>
  @endwhile
@endsection
