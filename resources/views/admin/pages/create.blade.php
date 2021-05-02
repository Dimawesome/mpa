@extends('admin.index')

@section('title', trans('app.admin.page.create'))

@section('header', trans('app.admin.page.create'))

@section('content')
    <div class="col-md-12">
        <form id="main-form"
              action="{{ action('Admin\PageController@store') }}"
              method="POST"
              class="form-validate-jquery">
            @csrf

            <input type="hidden" name="puid" id="puid" value="{{ $page->uid }}">

            @include('admin.pages._form')
        </form>
    </div>
@endsection
