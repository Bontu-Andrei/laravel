@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="text-center">{{ __('view.orderDetails') }}</h1>

    @include('partials.order')
@endsection
