<label class="radio-container">
    @if (!empty($label))
        {!! $label !!}
    @endif
    <input
            {{ isset($checked) && $checked ? ' checked' : '' }}
            {{ isset($disabled) && $disabled ? ' disabled=disabled' : '' }}
            {{ isset($readonly) && $readonly  ? ' readonly=readonly' : '' }}
            type="radio"
            name="{{ $name }}"
            id="{{ "$name-$value" }}"
            value="{{ $value }}"
            class="{{ $class ?? '' }} {{ $classes }}">
    <span class="checkmark"></span>
</label>
