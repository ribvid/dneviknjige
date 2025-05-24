@extends('layouts.app')

@section('content')
  <div class="wrapper flow flow-space-l-2xl fade-in-slide-up">
    @include('partials.page-header', ['title' => 'Dogajanje v preteklih letih'])

    @if (have_posts())
      <div class="grid" data-layout="thirds">
        @while(have_posts())
          @php
            the_post();
            $programmes = get_posts(['post_type' => 'programme', 'posts_per_page' => -1, 'meta_query' => [['key' => 'festival', 'value' => get_the_ID(), 'compare' => '=']], 'meta_key' => 'date', 'orderby' => 'meta_key', 'order' => 'ASC']);
            $cities = get_posts(['post_type' => 'city', 'posts_per_page' => -1, 'meta_query' => [['key' => 'festival', 'value' => get_the_ID(), 'compare' => '=']]]);
          @endphp

          <a href="{{ get_permalink() }}" class="flow festival-card">
            <figure>
              {!! wp_get_attachment_image(get_field('cover'), 'medium_large') !!}
            </figure>
            <h3 class="festival-card__heading">{!! get_the_title() !!} &rarr;</h3>
          </a>
        @endwhile
      </div>
    @endif
  </div>
@endsection
