@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="text-center">{{ __('view.orderDetails') }}</h1>

    <table class="table-bordered" style="width: 80%; margin: 20px auto;">
        <tr>
            <th>{{ __('view.placeholder.name') }}</th>
            <td colspan="4">{{ $order->customer_name }}</td>
        </tr>

        <tr>
            <th>{{ __('view.placeholder.contact') }}</th>
            <td colspan="4">{{ $order->customer_details }}</td>
        </tr>

        <tr>
            <th>{{ __('view.placeholder.comments') }}</th>
            <td colspan="4">{{ $order->customer_comments }}</td>
        </tr>

        <tr>
            <th>{{ __('view.orderDate') }}</th>
            <td colspan="4">{{ $order->created_at }}</td>
        </tr>

        <tr>
            <th rowspan="{{ count($order->products) + 1 }}">{{ __('view.pageName.products') }}</th>
            <th>{{ __('view.label.title') }}</th>
            <th>{{ __('view.label.description') }}</th>
            <th>{{ __('view.label.price') }}</th>
            <th>{{ __('view.image') }}</th>
        </tr>

        @foreach($order->products as $orderProduct)
            <tr>
                <td>{{ $orderProduct->title }}</td>
                <td>{{ $orderProduct->description }}</td>
                <td>{{ $orderProduct->price }}</td>
                <td><img src="{{ $orderProduct->image_url }}" width="100" height="100"></td>
            </tr>
        @endforeach

        <tr>
            <th>{{ __('view.totalPrice') }}</th>
            <td colspan="4">{{ $order->product_price_sum }}</td>
        </tr>
    </table>
@endsection
