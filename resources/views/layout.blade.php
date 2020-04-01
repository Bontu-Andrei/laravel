<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('view.training') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <style>
        html, body {
            background-color: #fff;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .product {
            border: 1px solid #9E9E9E;
            width: 70%;
            display: flex;
            align-items: center;
            justify-content: space-around;
            margin: 10px auto;
        }

        .container {
            border: 1px solid;
            height: auto;
            width: 60%;
            margin: 0 auto;
        }

        .navbar {
            height: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 50px;
        }
    </style>
</head>
<body>
    <header class="navbar">
        @yield('navigation')

        @if (session()->has('admin'))
            <div style="display: flex; padding: 0 25px;">
                <span>{{ __('view.welcome') }} {{ config('admin.name') }}</span>

                <form action="{{ route('logout') }}" method="post" style="margin-left: 15px;">
                    @csrf
                    @method('delete')
                    <button type="submit">{{ __('view.logout') }}</button>
                </form>
            </div>
        @endif
    </header>

    @yield('content')
</body>
</html>
