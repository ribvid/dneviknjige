@php $festival = get_field('festival') @endphp
@php $is_active = $festival->ID === get_field('active_festival', 'options') @endphp
@php $post_id = get_the_ID() @endphp

<div class="wrapper mb-m" data-element="breadcrumbs">
  @if($is_active)
    <a href="{{ get_post_type_archive_link('programme') }}" class="breadcrumb-link">
      {{ __('Program', 'sage') }}
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

<div class="wrapper flow flow-space-m-l">
  @php $programme = get_posts(['post_type' => 'programme', 'posts_per_page' => -1, 'meta_query' => [['key' => 'festival', 'value' => $festival->ID, 'compare' => '=']], 'orderby' => 'meta_key', 'meta_key' => 'date', 'order' => 'ASC']) @endphp
  @if (!empty($programme))
    <ul class="reel prose | reel-space-xs items-center" role="list" title="Program">
      @foreach ($programme as $programme_day)
        <li>
          @php $current = $programme_day->ID === $post_id @endphp
          <a href="{{ get_permalink($programme_day) }}" class="button"
             data-button-variant="{{ $current ? 'fill' : '' }}">
            @if ($is_active)
              {!! date_i18n('l, j. n.', strtotime(get_field('date', $programme_day, false))) !!}
            @else
              {!! date_i18n('j. n. Y', strtotime(get_field('date', $programme_day, false))) !!}
            @endif
          </a>
        </li>
      @endforeach
    </ul>
  @endif

  <article>
    <header class="prose">
      <h1>{!! $title !!}</h1>
    </header>

    <div>
      @if (have_rows('events'))
        <div class="divide-y">
          @while (have_rows('events'))
            @php the_row() @endphp
            <x-event :gallery="get_sub_field('gallery')">
              <x-slot:heading>{{ get_sub_field('heading') }}</x-slot:heading>
              <x-slot:subheading>{{ get_sub_field('time') }}</x-slot:subheading>
              <x-slot:description>{!! get_sub_field('description') !!}</x-slot:description>
            </x-event>
          @endwhile

          @if ($note = get_field('note'))
            <div class="flow pt-l-xl pb-m text-step-00">
              {!! $note !!}
            </div>
          @endif
        </div>
      @else
        <div class="prose my-m">
          {{ __('Program je v pripravi', 'sage') }}.
        </div>
      @endif
    </div>
  </article>
</div>
