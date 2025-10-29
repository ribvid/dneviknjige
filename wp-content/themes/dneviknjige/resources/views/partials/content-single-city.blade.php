@php
  $festival = get_field('festival');
  $is_active = $festival->ID === get_field('active_festival', 'options');
@endphp

<div class="wrapper mb-m" data-element="breadcrumbs">
  @if($is_active)
    <a href="{{ get_post_type_archive_link('city') }}" class="breadcrumb-link">
      {{ __('Partnerska mesta', 'sage') }}
    </a>
  @else
    <a href="{{ get_post_type_archive_link('festival') }}" class="breadcrumb-link">
      {{ __('Arhiv', 'sage') }}
    </a>
    /
    <a href="{{ get_permalink($festival) }}" class="breadcrumb-link">
      {{ sprintf('%s %s', __('Program', 'sage'), $festival->post_title ) }}
    </a>
  @endif
</div>

<div class="flow-space-l-2xl">
  <article @php post_class('wrapper') @endphp>
    <header class="prose">
      <h1>{!! $title !!}</h1>
    </header>

    <div>
      @if (have_rows('events'))
        <div class="divide-y">
          @while (have_rows('events'))
            @php the_row() @endphp
            <x-event variant="city" :gallery="get_sub_field('gallery')">
              <x-slot:heading>{{ get_sub_field('heading') }}</x-slot:heading>
              <x-slot:subheading>{{ get_sub_field('date') }}
                • {{ get_sub_field('location') }}</x-slot:subheading>
              <x-slot:description>{!! get_sub_field('description') !!}</x-slot:description>
            </x-event>
          @endwhile

          @php $organiser = get_field('organiser') @endphp
          @php $url = get_field('url') @endphp
          @if ($organiser || $url)
            <div class="flow pt-l-xl pb-m">
              @if ($organiser)
                <p class="text-step-00">{!! $organiser !!}</p>
              @endif

              @if ($url)
                <p class="flow-space-3xs text-step-000 text-dark-gray font-sans">
                  <a href="{{ $url }}">{{ parse_url($url)['host'] }}</a>
                </p>
              @endif
            </div>
          @endif
        </div>
      @else
        <div class="prose my-m">
          <p>{{ __('Program je v pripravi', 'sage') }}.</p>
        </div>
      @endif
    </div>
  </article>
</div>
