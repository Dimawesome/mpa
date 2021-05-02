@extends('admin.index')

@section('title', trans('app.admin.page.review'))

@section('header', trans('app.admin.page.review'))

@section('content')
    <div class="col-md-12">
        <form id="main-form"
              method="GET"
              class="form-validate-jquery">

            @include('admin.pages._form')
        </form>
    </div>
@endsection
