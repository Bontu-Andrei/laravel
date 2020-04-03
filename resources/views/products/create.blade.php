@extends('layout')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="flex-center">{{ __('view.add') }}</h1>

    <div style="display: flex; justify-content: center; margin-top: 40px;">
        <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data" style="width: 200px">
            @csrf

            @include('partials.product-form')
        </form>
    </div>
@endsection
