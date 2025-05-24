@extends('layouts.app')

@section('content')
  <div class="wrapper flow flow-space-l-2xl fade-in-slide-up">
    @include('partials.page-header')

    @if (! have_posts())
      <p>{{ __('Program partnerskih mest je v pripravi.', 'sage') }}</p>
    @else
      <div>
        <ul class="grid" role="list" data-layout="fourth">
          @while(have_posts())
            @php the_post() @endphp
            <li class="h-[100%]">@include('partials.cards.city', ['id' => get_the_ID()])</li>
          @endwhile
        </ul>
      </div>
    @endif
  </div>
@endsection
