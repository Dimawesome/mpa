@php
    $urlSegments = explode('/', url()->current());
    $pageCreateSegments = explode('/', action('Admin\PageController@create'));
    $active = isset(request()->segments()[1], request()->segments()[2])
    && $pageCreateSegments[4] === $urlSegments[4]
    && $pageCreateSegments[5] === $urlSegments[5]
        ? 'active'
        : '';
@endphp
<div class="sidebar-sticky">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ url()->current() === route('admin') ? 'active' : '' }}"
               href="{{ route('admin') }}"><em class="fa fa-home"></em>{{ trans('app.admin.dashboard') }}</a>
        </li>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
            <span>{{ trans('app.admin.tools') }}</span>
        </h6>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() === route('admin.menu') ? 'active' : '' }}"
               href="{{ route('admin.menu') }}"><em class="fa fa-sitemap"></em>{{ trans('app.admin.menu.list') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link nav-dropdown collapsed" href="#page-submenu" data-toggle="collapse" aria-expanded="false"
               class="dropdown-toggle"><em class="fa fa-clone"></em>{{ trans('app.admin.page.admin') }}<span
                        class="arrow"></span>
            </a>
            <ul class="list-unstyled submenu collapse" id="page-submenu">
                <li class="nav-item">
                    <a class="nav-link {{ $active }}"
                       href="{{ action('Admin\PageController@create') }}"><em
                                class="fa fa-plus"></em>{{ trans('app.admin.create') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ url()->current() === route('admin.page') ? 'active' : '' }}"
                       href="{{ route('admin.page') }}"><em
                                class="fa fa-bars"></em>{{ trans('app.admin.list') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ url()->current() === action('Admin\PageController@trash') ? 'active' : '' }}"
                       href="{{ route('admin.page.trash') }}"><em
                                class="fa fa-trash"></em>{{ trans('app.admin.trash_can') }}</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
