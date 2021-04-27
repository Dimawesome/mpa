@extends('admin.index')

@section('header')
    <div class="col-md-12">
        <h1 class="h2 m-0 pb-1 text-purple border-bottom">{{ trans('app.admin.page.review') }}</h1>
    </div>
@stop

@section('js')
    {{--    <script type="text/javascript" src="{{ URL::asset('assets/lib/tinymce/tinymce.min.js') }}"></script>--}}
    {{--    <script type="text/javascript" src="{{ URL::asset('js/editor.js') }}"></script>--}}
@endsection

@section('content')
    <div class="col-md-12">
        <form id="main-form"
              method="GET"
              class="form-validate-jquery">

            @include('admin.pages._form')
        </form>
    </div>
@endsection
