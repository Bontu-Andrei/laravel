@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">{{ __('view.pageName.cart') }}</h1>

        <div class="container">
            <div class="card">
                <div class="card-body">
                    @forelse ($products as $product)
                        <div class="d-flex justify-content-sm-between align-items-center border m-2">
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

                                <form class="m-2" action="{{ route('cart.destroy', ['productId' => $product->id]) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <button class="btn btn-danger btn-sm" type="submit">{{ __('view.delete') }}</button>
                                </form>
                            </div>
                    @empty
                        <h5 class="text-center">
                            {{ __('view.empty') }}
                        </h5>
                    @endforelse
                </div>

                <div class="card-footer">
                    <form action="{{ route('checkout') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text"
                                   name="customer_name"
                                   placeholder="{{ __('view.placeholder.name') }}"
                                   class="w-100"
                                   value="{{ old('customer_name') }}">

                            @error('customer_name')
                                <p style="color: red; font-size: small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text"
                                   name="contact_details"
                                   placeholder="{{ __('view.placeholder.contact') }}"
                                   class="w-100"
                                   value="{{ old('contact_details') }}">

                            @error('contact_details')
                                <p style="color: red; font-size: small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text"
                                   name="customer_comments"
                                   placeholder="{{ __('view.placeholder.comments') }}"
                                   class="w-100"
                                   value="{{ old('customer_comments') }}">

                            @error('customer_comments')
                                <p style="color: red; font-size: small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group w-100 d-flex justify-content-end">
                            <a class="btn btn-light btn-sm" href="{{ route('index') }}">{{ __('view.pageName.index') }}</a>

                            <button class="btn btn-info btn-sm" type="submit" name="checkout" style="margin-left: 10px;">{{ __('view.checkout') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
