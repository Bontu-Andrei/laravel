@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="text-center">{{ __('view.review') }}</h1>

    @foreach($reviews as $review)
        <div class="card" style="width: 80%; margin: 10px auto;">
            <div class="card-body">
                <div>
                    <span><b>{{ __('view.rating') }}</b></span>
                    <span>{{ $review->rating }}</span>
                </div>

                <div>
                    <span><b>{{ __('view.label.title') }}</b></span>
                    <span>{{ $review->title }}</span>
                </div>

                <div>
                    <span><b>{{ __('view.label.description') }}</b></span>
                    <span>{{ $review->description }}</span>
                </div>

                @include('reviews.destroy')
            </div>
        </div>
    @endforeach

    @include('reviews.create')
@endsection
