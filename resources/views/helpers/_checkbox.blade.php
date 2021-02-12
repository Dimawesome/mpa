<input
        {{ isset($checked) && $checked == true ? ' checked' : '' }}
        {{ isset($disabled) && $disabled == true ? ' disabled="disabled"' : '' }}
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        class="switchery {{ $class ?? '' }} {{ $classes }}"
        data-on-text="On"
        data-off-text="Off"
        data-on-color="success"
        data-off-color="default">
<label>
    @if (!empty($label))
        {!! $label !!}
    @endif
    @if (isset($help_class) && Lang::has('app.' . $help_class . '.' . $name . '.help'))
        <span class="checkbox-description">
			{!! trans('app.' . $help_class . '.' . $name . '.help') !!}
		</span>
    @endif
</label>
