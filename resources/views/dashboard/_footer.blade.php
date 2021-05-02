<hr class="w-100"/>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <ul class="p-0 m-0 text-center">
                    <li class="list-inline-item">
                        <a href="{{ route('admin') }}">
                            <span class="fa-stack fa-lg">
                                <img class="img-thumb" src="{{ url('/img/mpa.png') }}"
                                     alt="{{ trans('app.admin.admin') }}" title="{{ trans('app.admin.admin') }}">
                            </span>
                        </a>
                    </li>
                </ul>
                <p class="copyright text-muted">Copyright &copy; {{ trans('app.mpa_system') . ' ' . date('Y') }}</p>
            </div>
        </div>
    </div>
</footer>
