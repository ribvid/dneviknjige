{{--
  Template Name: Frontpage
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts())
    @php the_post() @endphp
    <div class="wrapper flow flow-space-xl-2xl py-s-m fade-in-slide-up" data-speed="slow">
      @if ($active_festival = get_field('active_festival', 'options'))
        {!! wp_get_attachment_image(get_field('cover', $active_festival), 'full', false, ['class' => 'homepage-cover']) !!}
      @else
        <div class="wrapper prose flow">
          <h1>Slovenski dnevi knjige</h1>
          @php the_content() @endphp
        </div>
      @endif

      @include('partials.funders', ['color' => 'bw'])
    </div>
  @endwhile
@endsection
