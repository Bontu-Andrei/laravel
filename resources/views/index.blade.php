@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">{{ __('view.pageName.index') }}</h1>

        @foreach ($products as $product)
            <div class="card m-2">
                <div class="d-flex justify-content-sm-between align-items-center">
                    <div class="m-2">
                        <img src="{{ $product->image_url }}" alt="{{ __('view.image_alt') }}" width="100px;" height="100px;">
                    </div>

                    <div class="m-2">
                        <div>
                            <b>{{ __('view.label.title') }}</b> {{ $product->title }}
                        </div>

                        <div>
                            <b>{{ __('view.label.description') }}</b> {{ $product->description }}
                        </div>

                        <div>
                            <b>{{ __('view.label.price') }}</b> {{ $product->price }}
                        </div>
                    </div>

                    <div class="d-flex">
                        <form action="{{ route('cart.store', ['productId' => $product->id]) }}" method="post">
                            @csrf
                            <button class="btn btn-primary btn-sm" type="submit">{{ __('view.add') }}</button>
                        </form>

                        <a class="btn btn-light btn-sm ml-2"
                           href="{{ route('reviews', ['productId' => $product->id]) }}">{{ __('view.review') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
