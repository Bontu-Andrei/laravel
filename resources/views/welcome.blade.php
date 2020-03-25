@extends('layout', ['page' => 'home'])

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                {{ __('view.training') }}
            </div>

            <div class="links">
                <a href="{{ route('index') }}">{{ __('view.pageName.index') }}</a>
                <a href="#">{{ __('view.pageName.cart') }}</a>
                <a href="#">{{ __('view.pageName.products') }}</a>
                <a href="#">{{ __('view.pageName.orders') }}</a>
            </div>
        </div>
    </div>
@endsection
