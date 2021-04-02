@extends('admin.index')

@section('content')
    <div class="col-md-12 mt-2 border-bottom form-group">
        <h1 class="h2 text-purple">{{ trans('app.admin.menu.list') }}</h1>
    </div>
    <div class="col-md-12 form-group">
        <a href="{{ action('Admin\MenuItemController@create') }}"
           class="btn btn-purple btn-md mc-modal-control" modal-size="xl" title="{{ trans('app.delete') }}">
            {{ trans('app.admin.menu.create') }}
        </a>
    </div>
    <div class="col-md-12">
        <div class="dd" id="preference-nestable">
            <ol class="dd-list">
                @if (!empty($items))
                    @foreach($items as $item)
                        @include('admin.menu_items._list_item', ['item' => $item])
                    @endforeach
                @endif
            </ol>

            @include('partials._html_loader')
        </div>
    </div>
@stop