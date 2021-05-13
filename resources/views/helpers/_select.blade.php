<select name="{{ $name }}"
        id="{{ $id ?? $name }}"
        {{ isset($disabled) && $disabled == true ? ' disabled=disabled' : '' }}
        @if(isset($placeholder))
        data-placeholder="{{ $placeholder }}"
        data-content-url="{{ $content_url ?? '' }}"
        @endif
        class="select select-search{{ $classes }} {{ $class ?? '' }}
        {{ isset($required) && !empty($required) ? 'required' : '' }}"
        {{ isset($multiple) && $multiple == true ? 'multiple=multiple' : '' }}
        {{ isset($readonly) && $readonly == true ? 'readonly=readonly' : '' }}
        {{ isset($onSelected['disable']) ? "data-disable={$onSelected['disable']}" : '' }}
        {{ isset($onSelected['enable']) ? "data-enable={$onSelected['enable']}" : '' }}
        data-overlay-id="{{ $overlayId ?? '' }}"
>
    @if (isset($include_blank))
        <option value="">{{ $include_blank }}</option>
    @endif
    @foreach($options as $option)
        <option
                @if (is_array($value))
                {{ in_array($option['value'], $value) ? ' selected' : '' }}
                @else
                {{ in_array($option['value'], explode(",", $value)) ? ' selected' : '' }}
                @endif
                value="{{ $option['value'] }}"
        >{{ htmlspecialchars($option['text']) }}</option>
    @endforeach
</select>
<span class="select-options d-none">{{ isset($pluginOptions) ? json_encode($pluginOptions) : '{}' }}</span>
<span class="display-options d-none">{{ isset($displayOptions) ? json_encode($displayOptions) : '{}' }}</span>
