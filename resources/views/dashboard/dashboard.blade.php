@extends('dashboard.index')

@section('title', trans('app.main'))

@section('menu_name', trans('app.main'))

@section('page_name', trans('app.dashboard_page'))

@section('content')
    <div class="col-md-12">
        <p>Svetainės tiklas - modulių funkcionalumo demonstracija bei puslapių, sukurtų administravimo sistemos
            dalyje, atvaizdavimas</p>
    </div>
    <div class="col-md-12">
        <div class="col-md-12 text-center form-group">
            <img class="img-thumbnail rounded p-0" src="{{ url('/img/web-anim.gif') }}"
                 alt="{{ trans('app.admin.admin') }}" title="{{ trans('app.admin.admin') }}">
        </div>
    </div>
@stop

