@extends('layouts.app')

@section('content')
  @include('partials.programme', [
    'heading' => __('Program', 'sage'),
    'festivalId' => get_field('active_festival', 'options'),
  ])
@endsection
