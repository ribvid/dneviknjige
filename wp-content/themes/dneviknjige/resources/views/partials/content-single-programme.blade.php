@php $festival = get_field('festival') @endphp
@php $is_active = $festival->ID === get_field('active_festival', 'options') @endphp
@php $post_id = get_the_ID() @endphp

<div class="wrapper mb-m" data-element="breadcrumbs">
  @if($is_active)
    <a href="{{ get_post_type_archive_link('programme') }}"
       class="font-sans text-step-00 font-medium no-underline text-dark-gray">
      {{ __('Program', 'sage') }}
    </a>
  @else
    <a href="{{ get_post_type_archive_link('festival') }}"
       class="font-sans text-step-00 font-medium no-underline text-dark-gray">
      {{ __('Arhiv', 'sage') }}
    </a>
    /
    <a href="{{ get_permalink($festival) }}"
       class="font-sans text-step-00 font-medium no-underline text-dark-gray">
      {{ sprintf('%s %s', __('Program', 'sage'), $festival->post_title ) }}
    </a>
  @endif
</div>

<div class="wrapper flow flow-space-m-l">
  @php $programme = get_posts(['post_type' => 'programme', 'posts_per_page' => -1, 'meta_query' => [['key' => 'festival', 'value' => $festival->ID, 'compare' => '=']], 'orderby' => 'meta_key', 'meta_key' => 'date', 'order' => 'ASC']) @endphp
  @if (!empty($programme))
    <ul class="reel reel-space-xs items-center" role="list" title="Program">
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

  <div>
    <article>
      <h1>
        {!! $title !!}
      </h1>

      <div>
        @if (have_rows('events'))
          <div class="divide-y">
            @while (have_rows('events'))
              @php the_row() @endphp
              <article class="flow py-l-2xl">
                <header class="flow">
                  <h2 class="text-green">{{ get_sub_field('heading') }}</h2>
                  <p class="flow-space-2xs text-green font-sans font-medium text-step-1">{{ get_sub_field('time') }}</p>
                </header>
                <div class="prose flow" style="margin-left: 0;">
                  {!! get_sub_field('description') !!}
                </div>
                @if ($gallery = get_sub_field('gallery'))
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
              </article>
            @endwhile

            @if ($note = get_field('note'))
              <div class="flow pt-l-xl pb-m text-step-00">
                {!! $note !!}
              </div>
            @endif
          </div>
        @else
          <p class="my-m">Program je v pripravi.</p>
        @endif
      </div>
    </article>
  </div>
</div>
