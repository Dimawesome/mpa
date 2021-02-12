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

</body>
</html>
