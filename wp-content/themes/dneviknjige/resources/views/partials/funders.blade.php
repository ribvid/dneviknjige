@if (have_rows('funders', 'options'))
  <ul class="funders cluster" role="list">
    @while (have_rows('funders', 'options'))
      @php the_row() @endphp
      <li>
        <span class="sr-only">{!! get_sub_field('name') !!}</span>
        {!! get_sub_field("logo_$color") !!}
      </li>
    @endwhile
  </ul>
@endif
