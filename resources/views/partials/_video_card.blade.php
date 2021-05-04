<div class="card">
    <div class="card-body">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe type="text/html" class="embed-responsive-item" src="{{ $videoUrl }}"
                    allow="autoplay"
                    title="{{ trans('app.admin.module_video_card.video') }}"></iframe>
        </div>
        <div class="card-text mt-3">{!! $text !!}</div>
    </div>
</div>
