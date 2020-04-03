<div style="margin: 15px 0;">
    <label for="title"><b>{{ __('view.label.title') }}</b></label>
    <input type="text"
           name="title"
           id="title"
           placeholder="{{ __('view.label.title') }}"
           value="{{ old('title', $product->title) }}">

    @error('title')
        <p style="color: red; font-size: small">{{ $message }}</p>
    @enderror
</div>

<div style="margin: 15px 0;">
    <label for="description"><b>{{ __('view.label.description') }}</b></label>
    <input type="text"
           name="description"
           id="description"
           placeholder="{{ __('view.label.description') }}"
           value="{{ old('description', $product->description) }}">

    @error('description')
        <p style="color: red; font-size: small">{{ $message }}</p>
    @enderror
</div>

<div style="margin: 15px 0;">
    <label for="price"><b>{{ __('view.label.price') }}</b></label>
    <input type="text"
           name="price"
           id="price"
           placeholder="{{ __('view.label.price') }}"
           value="{{ old('price', $product->price) }}">

    @error('price')
        <p style="color: red; font-size: small">{{ $message }}</p>
    @enderror
</div>

<div style="margin: 15px 0;">
    <label for="file"><b>{{ __('view.image') }}</b></label>

    @if ($action === 'edit')
        <div>
            <img src="{{ $product->image_url }}" alt="{{ __('view.image_alt') }}" width="100px;" height="100px;">
        </div>
    @endif

    <input type="file" id="file" name="image_path">

    @error('image_path')
        <p style="color: red; font-size: small">{{ $message }}</p>
    @enderror
</div>

<div style="margin: 15px 0; display: flex; justify-content: space-between;">
    <a href="{{ route('products') }}">{{ __('view.pageName.products') }}</a>
    <button type="submit" style="margin-right: 20px;">{{ __('view.save') }}</button>
</div>
