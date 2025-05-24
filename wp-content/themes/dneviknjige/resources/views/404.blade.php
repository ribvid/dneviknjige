@extends('layouts.app')

@section('content')
  <div class="wrapper prose flow">
    @include('partials.page-header', ['title' => 'Ne obstaja'])

    <p>{{ __(' Oprostite, stran, ki ste jo obiskali, ne obstaja. ', 'sage') }}</p>
  </div>
@endsection
