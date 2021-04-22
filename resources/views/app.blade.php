<!doctype html>
<html>
<head>
    <title>Modulinis puslapiu administravimas</title>

    @include('partials._head')

    @include('partials._js')

    @include('partials._css')

</head>
<body class="@yield('body_color')">

@yield('body')

@include('partials._modals')

@foreach (['success', 'error'] as $msg)
    @if(Session::has("alert-$msg"))
        <div class="alert-notify d-none" data-status="{{ $msg }}">{{ Session::get("alert-$msg") }}</div>
    @endif
@endforeach

</body>
</html>
