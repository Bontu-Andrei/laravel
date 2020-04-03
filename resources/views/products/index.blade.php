@extends('layout')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="flex-center">{{ __('view.pageName.products') }}</h1>

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

            <div style="display: flex; flex-direction: column; align-items: center; margin: 10px;">
                <div style="margin: 5px;">
                    <a href="#">{{ __('view.edit') }}</a>
                </div>

                <div style="margin: 5px;">
                    <form action="#" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">{{ __('view.delete') }}</button>
                    </form>
                </div>

                <div style="margin: 5px;">
                    <a href="#">{{ __('view.review') }}</a>
                </div>
            </div>
        </div>
    @endforeach

    <div style="display: flex; justify-content: space-evenly; align-items: center; margin-bottom: 50px;">
        <div>
            <a href="{{ route('product.create') }}">{{ __('view.add') }}</a>
        </div>

        <div>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                @method('delete')
                <button type="submit">{{ __('view.logout') }}</button>
            </form>
        </div>
    </div>
@endsection
