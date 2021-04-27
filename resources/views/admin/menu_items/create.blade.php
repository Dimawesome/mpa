<form method="POST" id="modal-form" class="form-validate-jquery">
    @csrf

    @include('admin.menu_items._form')

    <div class="modal-footer text-center d-block">
        <a href="{{ action('Admin\MenuItemController@store') }}"
           class="modal-submit" data-method="POST">
            <button class="btn btn-purple btn-flat">
                <em class="fa fa-check"></em>
                {{ trans('app.admin.save') }}
            </button>
        </a>
    </div>
</form>