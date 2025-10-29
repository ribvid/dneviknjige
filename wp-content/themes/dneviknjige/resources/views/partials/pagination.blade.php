@if ($pagination = paginate_links([
        'end_size' => 1,
        'mid_size' => 3,
        'prev_text' => __('Nazaj', 'sage'),
        'next_text' => __('Naprej', 'sage'),
      ]))
  <div class="pagination | cluster">{!! $pagination !!}</div>
@endif
