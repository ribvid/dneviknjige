@if ($intro && ($intro['heading'] || $intro['content']))
  <article class="intro">
    <div class="wrapper prose flow">
      @if ($intro['heading'])
        <h2>{!! $intro['heading'] !!}</h2>
      @endif

      @if ($intro['content'])
        {!! $intro['content'] !!}
      @endif

      @if ($intro['author'] || $intro['author_avatar'])
        <footer class="cluster intro__author">
          @if ($intro['author_avatar'])
            {!! wp_get_attachment_image($intro['author_avatar'], 'thumbnail') !!}
          @endif

          @if ($intro['author'])
            @php
              $author = "<strong>{$intro['author']}</strong>";
              if ($intro['author_position']) {
                $author .= ",<br>{$intro['author_position']}";
              }
            @endphp
            <div>{!! $author !!}</div>
          @endif
        </footer>
      @endif
    </div>
  </article>
@endif
