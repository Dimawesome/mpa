@extends('app')

@section('body_class', 'admin-panel')

@section('body')
    @include('admin.partials._navbar')

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                @include('admin.partials._sidebar')
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="align-items-center pb-2 mb-3">

                    <div class="col-md-12">
                        <h1 class="h2 m-0 pb-1 text-purple border-bottom">
                            @yield('header')
                        </h1>
                    </div>

                    <div class="content-body bg-light">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
@stop
