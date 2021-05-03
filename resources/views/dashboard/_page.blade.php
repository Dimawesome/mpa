@extends('dashboard.index')

@section('title', $menu->name ?? trans('app.mpa'))

@section('menu_name', $menu->name ?? trans('app.menu_title'))

@section('page_name', $page->title ?? trans('app.page_title'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            @foreach($modules as $module)
                @if ($module->name === 'text')
                    <div class="col-md-12 module-text-content">
                        {!! $module->text !!}
                    </div>
                @elseif ($module->name === 'card')
                    <div class="col-md-{{ $module->width }} text-{{ $module->align }} my-3">
                        @include('partials._card', [
                            'title' => $module->title,
                            'text' => $module->text,
                            'url' => $module->url
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
    </div>
@stop
