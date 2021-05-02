<!doctype html>
<html>
<head>
    <title>
        @yield('title', trans('app.mpa')) - {{ trans('app.mpa') }}
    </title>

    @include('partials._head')

    @if (!isset($preview) || !$preview)
        @include('partials._css')

        @include('partials._js')
    @endif

</head>
<body class="@yield('body_class')">

@yield('body')

@foreach (['success', 'error'] as $msg)
    @if(Session::has("alert-$msg"))
        <div class="alert-notify d-none" data-status="{{ $msg }}">{{ Session::get("alert-$msg") }}</div>
    @endif
@endforeach

</body>
</html>
