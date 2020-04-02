@extends('layout')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="flex-center">{{ __('view.pageName.cart') }}</h1>

    @if ( ! empty(session('cart')))
        <div class="container">
            @foreach ($products as $product)
                <div class="product">
                    <div style="display: flex; margin: 5px;">
                        <img src="{{ $product->image_url }}" alt="{{ __('view.image_alt') }}" width="100px;"
                             height="100px;">
                    </div>

                    <div>
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

                    <div style="margin: 5px;">
                        <form action="{{ route('cart.destroy', ['productId' => $product->id]) }}" method="post">
                            @csrf
                            @method('delete')

                            <button type="submit">{{ __('view.delete') }}</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <form action="{{ route('checkout') }}" method="post">
                @csrf
                <div style="width: 70%; margin: 10px auto;">
                    <input type="text"
                           name="customer_name"
                           placeholder="{{ __('view.placeholder.name') }}"
                           style="width: 100%;"
                           value="{{ old('customer_name') }}">

                    @error('customer_name')
                        <p style="color: red; font-size: small">{{ $message }}</p>
                    @enderror
                </div>

                <div style="width: 70%; margin: 10px auto;">
                    <input type="text"
                           name="contact_details"
                           placeholder="{{ __('view.placeholder.contact') }}"
                           style="width: 100%; height: 20px;"
                           value="{{ old('contact_details') }}">

                    @error('contact_details')
                        <p style="color: red; font-size: small">{{ $message }}</p>
                    @enderror
                </div>

                <div style="width: 70%; margin: 10px auto;">
                    <input type="text"
                           name="customer_comments"
                           placeholder="{{ __('view.placeholder.comments') }}"
                           style="width: 100%; height: 30px;"
                           value="{{ old('customer_comments') }}">

                    @error('customer_comments')
                        <p style="color: red; font-size: small">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; justify-content: flex-end; width: 70%; margin: 0 auto;">
                    <a href="{{ route('index') }}">{{ __('view.pageName.index') }}</a>

                    <button type="submit" name="checkout" style="margin-left: 10px;">{{ __('view.checkout') }}</button>
                </div>
            </form>
        </div>
    @else
        <h5 class="content">
            {{ __('view.empty') }}
        </h5>
    @endif
@endsection
