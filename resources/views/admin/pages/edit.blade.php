@extends('admin.index')

@section('title', trans('app.admin.page.editing'))

@section('header', trans('app.admin.page.editing'))

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
