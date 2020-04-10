@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="text-center">{{ __('view.edit') }}</h1>

    <div class="d-flex justify-content-center m-5">
        <form action="{{ route('products.update', ['product' => $product->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            @include('partials.product-form')
        </form>
    </div>
@endsection
