<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name', 'Laravel')}}</title>

    {{-- Styles --}}
    <link rel="stylesheet" href="/css/app.css">

</head>
<body>

<div id="app" class="container">
    <div class="row">
        <div id="wrapper">
            <div class="overlay"></div>

            {{-- Sidebar content --}}
            @yield('the_sidebar')

            {{-- Page Content --}}
            <div id="page-content-wrapper">

                {{-- Sidebar hamburger --}}
                @if(!Auth::guest())
                    <button type="button" class="hamburger is-closed animated fadeInLeft" data-toggle="offcanvas">
                        <span class="hamb-top"></span>
                        <span class="hamb-middle"></span>
                        <span class="hamb-bottom"></span>
                    </button>
                @endif

                <div id="{{ $vueVM }}" class="container">
                    {{-- Page content section --}}
                    @yield('content')
                    {{-- Modal dialogs --}}
                    @yield('modals')
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="/js/app.js"></script>

</body>

</html>