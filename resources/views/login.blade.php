@extends('layout')

@section('content')
    <div class="flex-center" style="margin: 30px auto; width: 50%;">
        <form action="{{ route('login.store') }}" method="post">
            @csrf

            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <label for="name">{{ __('view.placeholder.name') }}:</label>
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="{{ __('view.placeholder.name') }}"
                           value="{{ old('name') }}">
                </div>

                <div>
                    @error('name')
                        <p style="color: red; font-size: small">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <div style="margin-bottom: 10px;">
                    <label for="password">{{ __('view.placeholder.password') }}:</label>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="{{ __('view.placeholder.password') }}"
                           value="{{ old('password') }}">
                </div>

                <div>
                    @error('password')
                        <p style="color: red; font-size: small">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                @error('login')
                    <p style="color: red; font-size: small">{{ $message }}</p>
                @enderror
            </div>

            <div style="float: right;">
                <button type="submit">{{ __('view.login') }}</button>
            </div>
        </form>
    </div>
@endsection
