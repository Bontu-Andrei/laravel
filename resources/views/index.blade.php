@extends('layout')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')

    <h1 class="flex-center">{{ __('view.pageName.index') }}</h1>

    @foreach ($products as $product)
        <div class="product">
            <div style="display: flex; margin: 5px;">
                <img src="{{ $product->image_url }}" alt="{{ __('view.image_alt') }}" width="100px;" height="100px;">
            </div>

            <div style="margin-right: 5px;">
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

            <form action="{{ route('cart.store', ['productId' => $product->id]) }}" method="post">
                @csrf
                <button type="submit">{{ __('view.add') }}</button>
            </form>
        </div>
    @endforeach

@endsection
