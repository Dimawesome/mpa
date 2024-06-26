@extends('admin.index')

@section('title', trans('app.admin.page.trash_can'))

@section('header', trans('app.admin.page.trash_can'))

@section('content')
    <div class="col-md-12">
        @if (!empty($items))
            <form class="listing-form"
                  data-url="{{ action('Admin\PageController@trashListing') }}"
                  per-page="{{ App\Models\Page::$itemsPerPage }}">
                @csrf

                <div class="row">
                    <div class="col-md-3">
                        @include('helpers.popover_confirm', [
                            'classes' => 'btn btn-purple',
                            'title' => trans('app.popover.trash_clean_confirm'),
                            'ajaxUrl' => action('Admin\PageController@deleteAll'),
                            'btnContent' => '<em class="fa fa-recycle row-icon"></em>' . trans('app.admin.trash_clean'),
                            'overlayId' => 'table-ovelay',
                            'placement' => 'bottom',
                            'disabled' => $items->count() <= 0
                        ])
                    </div>
                    <div class="col-md-9 text-right">
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
                                        <option value="pages.created_at">
                                            {{ trans('app.admin.created_at') }}
                                        </option>
                                        <option value="pages.updated_at">
                                            {{ trans('app.admin.removed_at') }}
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
                'text' => trans('app.admin.menu.empty_list')
            ])
        @endif
    </div>
@stop
