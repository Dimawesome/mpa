@inject('menu', 'App\Models\MenuItem')
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav" aria-label="mpa-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">{{ trans('app.mpa') }}</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            {{ trans('app.menu') }}
            <em class="fa fa-bars"></em>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ url()->current() === route('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard') }}">{{ trans('app.main') }}</a>
                </li>
                @foreach($menu->getAllActiveSortedByOrder() as $item)
                    @php $urlSegments = explode('/', $item['url']); @endphp
                    <li class="nav-item {{ isset($urlSegments[3], Request::segments()[2]) && Request::segments()[2] === $urlSegments[3] ? 'active' : '' }}">
                        <a class="nav-link" href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>