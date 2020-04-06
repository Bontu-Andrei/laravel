@extends('layouts.app')

@section('navigation')
    @include('partials.navigation')
@endsection

@section('content')
    <h1 class="text-center">{{ __('view.pageName.orders') }}</h1>

    <div style="width: 90%; margin: 0 auto">
        @foreach($orders as $order)
            <table class="table-bordered mb-5 text-center" style="margin: 0 auto; width: 80%;">
                <tr>
                    <th>{{ __('view.placeholder.name') }}</th>
                    <td>{{ $order->customer_name }}</td>
                </tr>

                <tr>
                    <th>{{ __('view.placeholder.contact') }}</th>
                    <td>{{ $order->customer_details }}</td>
                </tr>

                <tr>
                    <th>{{ __('view.placeholder.comments') }}</th>
                    <td>{{ $order->customer_comments }}</td>
                </tr>

                <tr>
                    <th>{{ __('view.orderDate') }}</th>
                    <td>{{ $order->created_at }}</td>
                </tr>

                <tr>
                    <th>{{ __('view.totalPrice') }}</th>
                    <td>{{ $order->product_price_sum }}</td>
                </tr>

                <tr>
                    <th>{{ __('view.orderDetails') }}</th>
                    <td><a href="{{ route('order', ['orderId' => $order->id]) }}">{{ __('view.orderDetails') }}</a></td>
                </tr>
            </table>
        @endforeach
    </div>
@endsection
