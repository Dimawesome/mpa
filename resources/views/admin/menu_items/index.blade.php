@extends('admin.index')

@section('content')
    <div class="col-md-12 mt-2 form-group">
        <h1 class="h2 pb-1 text-purple border-bottom">{{ trans('app.admin.menu.list') }}</h1>
    </div>
    <div class="col-md-12 form-group">
        <a href="{{ action('Admin\MenuItemController@create') }}"
           class="btn btn-purple mc-modal-control" modal-size="xl" title="{{ trans('app.admin.menu.create') }}">
            {{ trans('app.admin.menu.create') }}
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
            </div>
        @else
            @include('partials._empty_list', [
                'icon' => 'fa fa-sitemap',
                'text' => trans('app.admin.menu.empty_list')
            ])
        @endif
    </div>
@stop