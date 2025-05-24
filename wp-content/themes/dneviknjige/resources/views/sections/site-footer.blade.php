<footer class="site-footer">
  <div class="wrapper flow flow-space-xl-2xl">
    <img src="{{ Vite::asset('resources/images/dsp-logo.svg') }}"
         alt="Društvo slovenskih pisateljev"
         class="site-footer__logo">
    @include('partials.funders', ['color' => 'white'])
  </div>
</footer>
