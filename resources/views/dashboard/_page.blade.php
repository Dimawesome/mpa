@extends('dashboard.index')

@section('title', $menu->name ?? trans('app.mpa'))

@section('menu_name', $menu->name ?? trans('app.mpa'))

@section('page_name', $page->title ?? trans('app.page_title'))

@section('content')
    <div class="row">
        @foreach($modules as $module)
            @if ($module->name === 'text')
                <div class="col-md-12 module-text-content">
                    {!! $module->text !!}
                </div>
            @elseif ($module->name === 'card' || $module->name === 'video_card')
                <div class="col-md-{{ $module->width }}{{ isset($module->align) ? " text-$module->align" : '' }} my-3">
                    @include("partials._$module->name", [
                        'title' => $module->title ?? '',
                        'text' => $module->text,
                        'url' => $module->url ?? '',
                        'videoUrl' => isset($module->additional_data['youtube_url'])
                            ? $module->additional_data['youtube_url'][0]
                            : ''
                    ])
                </div>
            @elseif (isset($module->additional_data) && $module->additional_data)
                @foreach($module->additional_data as $data)
                    @if($module->name === 'file')
                        <div class="col-md-{{ $data['width'] }} my-3">
                            @include('partials._file', ['name' => $data['name'], 'url' => $data['url']])
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@stop
