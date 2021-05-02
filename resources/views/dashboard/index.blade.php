@extends('app')

@section('title', trans('app.main'))

@section('body')
    @include('dashboard._navbar')

    <header class="masthead">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="page-heading">
                        <h1>
                            @yield('menu_name')
                        </h1>
                        <span class="subheading">
                            @yield('page_name')
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto mb-7">
                @yield('content')
            </div>
        </div>
    </div>

    @if (!isset($preview) || !$preview)
        @include('dashboard._footer')
    @endif
@stop
