@extends('admin.index')

@section('header')
    <div class="col-md-12">
        <h1 class="h2 m-0 pb-1 text-purple border-bottom">{{ trans('app.admin.page.list') }}</h1>
    </div>
@stop

@section('content')
    <div class="col-md-12">
        @if (!empty($items))
            <form class="listing-form"
                  data-url="{{ action('Admin\PageController@listing') }}"
                  per-page="{{ App\Models\Page::$itemsPerPage }}">
                @csrf

                <div class="row">
                    <div class="col-md-2">
                        <a href="{{ action('Admin\PageController@create') }}" type="button"
                           class="btn btn-purple"><em class="fa fa-plus"></em>{{ trans('app.admin.page.create') }}</a>
                    </div>
                    <div class="col-md-10 text-right">
                        @if ($items->count() >= 0)
                            <div class="filter-box">
                                <span class="filter-group">
                                    <span class="title text-muted">
                                        {{ trans('app.admin.sort_by') }}
                                    </span>
                                    <select class="select select-auto" name="sort-order">
                                        <option value="pages.title">
                                            {{ trans('app.admin.title') }}
                                        </option>
                                        <option value="pages.is_active">
                                            {{ trans('app.admin.status') }}
                                        </option>
                                        <option value="pages.created_at">
                                            {{ trans('app.admin.created_at') }}
                                        </option>
                                        <option value="pages.updated_at">
                                            {{ trans('app.admin.updated_at') }}
                                        </option>
                                    </select>
                                    <button class="btn btn-xs btn-white sort-direction"
                                            rel="desc"
                                            title="{{ trans('app.change_sort_direction') }}"
                                            type="button">
                                        <em class="fa fa-sort-amount-desc"></em>
                                    </button>
                                </span>
                                <span class="text-nowrap">
                                    <input name="search_keyword" class="form-control search"
                                           placeholder="{{ trans('app.admin.type_to_search') }}"/>
                                    <em class="fa fa-search keyword_search_button"></em>
                               </span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="pml-table-container"></div>
            </form>
        @else
            @include('partials._empty_list', [
                'icon' => 'fa fa-sitemap',
                'text' => trans('app.admin.empty_list')
            ])
        @endif
    </div>
@stop
