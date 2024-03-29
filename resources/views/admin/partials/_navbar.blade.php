<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-purple justify-content-between p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('admin') }}">{{ trans('app.admin.admin') }}</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="{{ route('dashboard') }}" id="main">
                <em class="fa fa-paper-plane-o "></em>{{ trans('app.mpa_web') }}
            </a>
        </li>
        <li class="nav-item text-nowrap">
            @include('admin.partials._logout')
        </li>
    </ul>
</nav>
