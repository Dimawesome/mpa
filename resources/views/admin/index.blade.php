@extends('app')

@section('body')
    @include('admin.partials._navbar')

    <div class="container-fluid admin-panel">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                @include('admin.partials._sidebar')
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                <div class="align-items-center pb-2 mb-3">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
@stop
