@extends('admin.index')

@section('header')
    <div class="col-md-12">
        <h1 class="h2 m-0 pb-1 text-purple border-bottom">{{ trans('app.admin.menu.list') }}</h1>
    </div>
@stop

@section('content')
    <div class="col-md-12 form-group">
        <a href="{{ action('Admin\MenuItemController@create') }}"
           class="btn btn-purple mc-modal-control" modal-size="xl" title="{{ trans('app.admin.menu.create') }}"><em
                    class="fa fa-plus"></em>{{ trans('app.admin.menu.create') }}
        </a>
    </div>
    <div class="col-md-12">
        @if (!empty($items))
            <div class="dd" id="preference-nestable" data-action="{{ action('Admin\MenuItemController@sort') }}">
                <ol class="dd-list">
                    @foreach($items as $item)
                        @include('admin.menu_items._list_item', ['item' => $item])
                    @endforeach
                </ol>

                @include('partials._html_loader', ['id' => 'dd-overlay'])
            </div>
        @else
            @include('partials._empty_list', [
                'icon' => 'fa fa-sitemap',
                'text' => trans('app.admin.empty_list')
            ])
        @endif
    </div>
@stop