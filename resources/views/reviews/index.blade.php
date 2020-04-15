@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="text-center">{{ __('view.review') }}</h1>

{{--    @if ($type == 'product')--}}
{{--        <div class="card mb-3" style="max-width: 800px; margin: 0 auto;">--}}
{{--            <div class="row no-gutters">--}}
{{--                <div class="col-md-4 d-flex align-items-center">--}}
{{--                    <img src="{{ $item->image_url }}" class="card-img" alt="{{ __('view.image_alt') }}" width="100px" height="150px">--}}
{{--                </div>--}}
{{--                <div class="col-md-8">--}}
{{--                    <div class="card-body">--}}
{{--                        <div>--}}
{{--                            <h5 class="card-title"><b>{{ __('view.label.title') }}:</b> {{ $item->title }}</h5>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <p class="card-text"><b>{{ __('view.label.description') }}:</b> {{ $item->description }}</p>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <p class="card-text"><b>{{ __('view.label.price') }}</b> {{ $item->price }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    @if ($type == 'order')--}}
{{--        @include('partials.order', ['order' => $item])--}}
{{--    @endif--}}

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
