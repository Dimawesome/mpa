@inject('request', \Illuminate\Http\Request)
<div class="sidebar-sticky">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ url()->current() === route('admin') ? 'active' : '' }}" href="{{ route('admin') }}">
                <em class="fa fa-home"></em>
                {{ trans('app.admin.dashboard') }}
            </a>
        </li>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
            <span>{{ trans('app.admin.tools') }}</span>
        </h6>
        <li class="nav-item">
            <a class="nav-link {{ url()->current() === route('admin.menu') ? 'active' : '' }}" href="{{ route('admin.menu') }}">
                <em class="fa fa-sitemap"></em>
                {{ trans('app.admin.menu.list') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{--{{ url()->current() === route('admin.page') ? 'active' : '' }}--}}" href="{{--{{ route('admin.page') }}--}}">
                <em class="fa fa-list"></em>
                {{ trans('app.admin.page.list') }}
            </a>
        </li>
    </ul>
</div>
