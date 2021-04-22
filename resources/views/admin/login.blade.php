@extends('app')

@section('body_color')
    bg-purple
@stop

@section('body')
    <div id="login">
        <h3 class="text-center text-white pt-5">{{ trans('app.admin.admin') }}</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form jquery-form-validate"
                              action="{{ action('Admin\AdminController@login') }}" method="post">
                            @csrf
                            <h3 class="text-center text-purple">{{ trans('app.admin.login_form') }}</h3>
                            <div class="form-group">
                                @include('helpers.form_control', [
                                    'type' => 'text',
                                    'name' => 'username',
                                    'label' => trans('app.admin.username')
                                ])
                            </div>
                            <div class="form-group">
                                @include('helpers.form_control', [
                                    'type' => 'password',
                                    'name' => 'password',
                                    'label' => trans('app.admin.password')
                                ])
                            </div>
                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-purple">{{ trans('app.admin.login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
