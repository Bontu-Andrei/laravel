@component('mail::message')
# {{ __('view.thanks') }}: {{ $data['customer_name'] }}

## {{ __('view.details') }}: {{ $data['contact_details'] }}

### {{ __('view.comments') }}: {{ $data['customer_comments'] }}

@component('mail::table')
| {{ __('view.image') }} | {{ __('view.label.title') }} | {{ __('view.label.description') }} | {{ __('view.label.price') }} |
| :-------------------------: | :---------------------: | :---------------------------: | :-----------------------:
@foreach($products as $product)
| <img src="{{ $product->getImageEncoding() }}" alt="{{ __('view.image_alt') }}" width="100px" height="100px"> | {{ $product['title'] }} | {{ $product['description'] }} | {{ $product['price'] }} |
@endforeach
@endcomponent

@component('mail::button', ['url' => 'http://localhost:8000/index'])
{{ __('view.back') }}
@endcomponent

{{ __('view.thank') }},<br>
{{ config('app.name') }}
@endcomponent

