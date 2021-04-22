<button type="button"
        class="btn btn-popover {{ $classes ?? '' }}"
        data-toggle="popover"
        data-container="body"
        data-placement="{{ $placement ?? 'top' }}"
        title="{!! $title ?? '' !!}"
        {{ isset($ajaxUrl) ? "data-ajax-url='$ajaxUrl'" : '' }}>{!! $btnContent ?? '' !!}
