<div class="d-flex justify-content-center">
    <form action="{{ route('reviews.create', ['productId' => $product->id]) }}" method="post">
        @csrf

        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div>
            <div>
                <label for="rating"><b>{{ __('view.rating') }}</b></label>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="radio" name="rating" id="rating" value="5" {{ old('rating') == "5" ? 'checked' : '' }}/> 5
                    </div>

                    <div class="input-group-text">
                        <input type="radio" name="rating" id="rating" value="4" {{ old('rating') == "4" ? 'checked' : '' }}/> 4
                    </div>

                    <div class="input-group-text">
                        <input type="radio" name="rating" id="rating" value="3" {{ old('rating') == "3" ? 'checked' : '' }}/> 3
                    </div>

                    <div class="input-group-text">
                        <input type="radio" name="rating" id="rating" value="2" {{ old('rating') == "2" ? 'checked' : '' }}/> 2
                    </div>

                    <div class="input-group-text">
                        <input type="radio" name="rating" id="rating" value="1" {{ old('rating') == "1" ? 'checked' : '' }}/> 1
                    </div>
                </div>
            </div>

            @error('rating')
                <p style="color: red; font-size: small">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <div>
                <label for="title"><b>{{ __('view.label.title') }}</b></label>
            </div>

            <input type="text"
                   class="form-control"
                   id="title"
                   name="title"
                   value="{{ old('title') }}"
                   placeholder="{{ __('view.label.title') }}">

            @error('title')
                <p style="color: red; font-size: small">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <div>
                <label for="description"><b>{{ __('view.label.description') }}</b></label>
            </div>

            <input name="description"
                   class="form-control"
                   id="description"
                   value="{{ old('description') }}"
                   placeholder="{{ __('view.label.description') }}">

            @error('description')
                <p style="color: red; font-size: small">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-center mb-5">
            <button class="btn btn-primary btn-sm" type="submit" name="review">{{ __('view.addReview') }}</button>
        </div>
    </form>
</div>
