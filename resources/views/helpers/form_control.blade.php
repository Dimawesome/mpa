<?php

$label = isset($label) ? $label : (Lang::has('app.' . $name) ? trans('app.' . $name) : '');
$var_name = str_replace('[]', '', $name);
$var_name = str_replace('][', '.', $var_name);
$var_name = str_replace('[', '.', $var_name);
$var_name = str_replace(']', '', $var_name);
$var_name = preg_replace('/(\D*)_\d+/', '${1}_*', $var_name);
$classes = (isset($rules) && isset($rules[$var_name])) ? ' ' . str_replace('|', ' ', $rules[$var_name]) : '';
$required = (isset($rules) && isset($rules[$var_name]) && in_array('required', explode('|', $rules[$var_name]))) ? true : '';

?>

@if (!empty($errors) && ($type === 'checkbox'))
    <div class="form-group{{ $errors->has($var_name) ? ' has-error' : '' }} control-{{ $type }} {{ $parent_class ?? '' }}">
        @include('helpers._' . $type)
    </div>
@elseif (!empty($errors))
    <div class="form-group{{ $errors->has($var_name) ? ' has-error' : '' }} control-{{ $type }} {{ $parent_class ?? '' }}">
        @if (!empty($label))
            <label class="text-purple">
                {!! $label !!}
                @if ($required)
                    <span class="text-danger">*</span>
                @endif
            </label>
        @endif

        @include('helpers._' . $type)

        @if (isset($help_class) && Lang::has('app.' . $help_class . '.' . $name . '.help'))
            <div class="help alert alert-info">
                {!! trans('app.' . $help_class . '.' . $name . '.help') !!}
            </div>
        @endif

        @if (isset($help))
            <div class="help alert alert-info">
                {!! $help !!}
            </div>
        @endif

        @if ($errors->has($var_name))
            <span class="help-block">
                {{ $errors->first($var_name) }}
            </span>
        @endif
    </div>
@endif
