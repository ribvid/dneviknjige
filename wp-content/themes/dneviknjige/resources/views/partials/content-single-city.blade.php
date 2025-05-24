@php $festival = get_field('festival') @endphp
@php $is_active = $festival->ID === get_field('active_festival', 'options') @endphp

<div class="wrapper mb-m" data-element="breadcrumbs">
  @if($is_active)
    <a href="{{ get_post_type_archive_link('city') }}"
       class="font-sans text-step-00 font-medium no-underline text-dark-gray">
      {{ __('Partnerska mesta', 'sage') }}
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

<div class="flow-space-l-2xl">
  <article @php post_class('wrapper') @endphp>
    <h1>{!! $title !!}</h1>

    <div>
      @if (have_rows('events'))
        <div class="divide-y">
          @while (have_rows('events'))
            @php the_row() @endphp
            <article class="flow py-l-xl">
              <header class="flow">
                <h2 class="text-terracotta">{{ get_sub_field('heading') }}</h2>
                <p class="flow-space-2xs text-terracotta font-sans font-medium">
                  {{ get_sub_field('date') }} • {{ get_sub_field('location') }}
                </p>
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
        <p class="my-m">Program je v pripravi.</p>
      @endif
    </div>
  </article>
</div>
