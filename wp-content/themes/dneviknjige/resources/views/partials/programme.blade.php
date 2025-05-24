<div class="wrapper flow flow-space-l-2xl fade-in-slide-up">
  @include('partials.page-header', ['title' => $heading ?? __('Program', 'sage')])

  @php
    $programmes = get_posts([
      'post_type' => 'programme',
      'posts_per_page' => -1,
      'meta_query' => [
        ['key' => 'festival', 'value' => $festivalId, 'compare' => '=']
      ],
      'meta_key' => 'date',
      'orderby' => 'meta_key',
      'order' => 'ASC'
    ]);

    $cities = get_posts([
      'post_type' => 'city',
      'posts_per_page' => -1,
      'meta_query' => [
        ['key' => 'festival', 'value' => $festivalId, 'compare' => '=']
      ]
    ]);
  @endphp

  @if (!empty($programmes))
    <div class="flow">
      <h3>{{ __('Program v Ljubljani', 'sage') }}</h3>
      <ul class="grid flow-space-m" data-layout="fourth" role="list">
        @foreach ($programmes as $programme)
          <li class="h-[100%]">@include('partials.cards.programme', ['id' => $programme->ID])</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if (!empty($cities))
    <div class="flow">
      <h3>{{ __('Program v partnerskih mestih', 'sage') }}</h3>
      <ul class="grid flow-space-m" role="list" data-layout="fourth">
        @foreach ($cities as $city)
          <li class="h-[100%]">@include('partials.cards.city', ['id' => $city->ID])</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
