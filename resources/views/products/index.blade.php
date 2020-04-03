@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center">{{ __('view.pageName.products') }}</h1>

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

                    <div class="m-2 d-flex">
                        <div class="m-2">
                            <a class="btn btn-light btn-sm"
                               href="{{ route('product.edit', ['product' => $product->id]) }}">{{ __('view.edit') }}</a>
                        </div>

                        <div class="m-2">
                            <form action="#" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" type="submit">{{ __('view.delete') }}</button>
                            </form>
                        </div>

                        <div class="m-2">
                            <a class="btn btn-light btn-sm" href="#">{{ __('view.review') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div style="display: flex; justify-content: space-evenly; align-items: center; margin-bottom: 50px;">
            <div>
                <a class="btn btn-primary" href="{{ route('product.create') }}">{{ __('view.add') }}</a>
            </div>

            <div>
                <a class="btn btn-secondary" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection
