@extends('admin.index')

@section('header')
    <div class="col-md-12">
        <h1 class="h2 m-0 pb-1 text-purple border-bottom">{{ trans('app.admin.page.create') }}</h1>
    </div>
@stop

@section('js')
    {{--    <script type="text/javascript" src="{{ URL::asset('assets/lib/tinymce/tinymce.min.js') }}"></script>--}}
    {{--    <script type="text/javascript" src="{{ URL::asset('js/editor.js') }}"></script>--}}
@endsection

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
