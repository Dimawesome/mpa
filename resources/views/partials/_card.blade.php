<div class="card">
    <div class="card-body">
        <h5 class="card-title font-weight-bold">{{ $title }}</h5>
        <p class="card-text">{{ $text }}</p>
        @if ($url)
            <a href="{{ $url }}" class="btn btn-white">{{ trans('app.more') }}</a>
        @endif
    </div>
</div>
