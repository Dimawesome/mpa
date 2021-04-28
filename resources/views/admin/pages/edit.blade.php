@extends('admin.index')

@section('header')
    <div class="col-md-12">
        <h1 class="h2 m-0 pb-1 text-purple border-bottom">{{ trans('app.admin.page.editing') }}</h1>
    </div>
@stop

@section('content')
    <div class="col-md-12">
        <form id="main-form"
              action="{{ action('Admin\PageController@update', $page->uid) }}"
              method="POST"
              class="form-validate-jquery">
            @csrf

            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" name="puid" id="puid" value="{{ $page->uid }}">

            @include('admin.pages._form')
        </form>
    </div>
@endsection
