{{--
  Template Name: Frontpage
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts())
    @php the_post() @endphp
    @if ($active_festival = get_field('active_festival', 'options'))
      <h1 class="sr-only">{{ __('Slovenski dnevi knjige', 'sage') }}</h1>

      <div class="flow | flow-space-xl-2xl py-m-l fade-in-slide-up" data-speed="slow">
        <div class="wrapper">
          {!! wp_get_attachment_image(get_field('cover', $active_festival), 'full', false, ['class' => 'homepage-cover']) !!}
        </div>

        @include('partials.homepage-intro', ['intro' => get_field('intro', $active_festival)])

        <div class="wrapper flow">
          @include('partials.funders', ['color' => 'bw'])
        </div>
      </div>
    @endif
  @endwhile
@endsection
