<input
        {{ isset($disabled) && $disabled ? ' disabled="disabled"' : "" }}
        id="{{ $name }}"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ $value ?? '' }}"
        type="text"
        name="{{ $name }}"
        {{ isset($max) ? "maxlength=$max" : '' }}
        {{ isset($min) ? "minlength=$min" : '' }}
        class="form-control{{ $classes }} {{ $class ?? '' }}"
        {!! isset($default_value) ? "default-value='$default_value'" : '' !!}
        {{ isset($readonly) && $readonly ? "readonly=readonly" : "" }}
>
