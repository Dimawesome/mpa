<a class="nav-link" href="javascript:void(0)" id="logout">
    <em class="fa fa-fw fa-power-off"></em>{{ trans('app.admin.logout') }}
</a>
<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
