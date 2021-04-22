<form method="POST" id="modal-form" class="form-validate-jquery">
    @csrf

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="order" value="{{ $menu['order'] }}">

    @include('admin.menu_items._form')


    <div class="modal-footer text-center d-block">
        <a href="{{ action("Admin\MenuItemController@update", ['muid' => $menu['uid']]) }}"
           class="modal-submit" data-method="POST">
            <button class="btn btn-purple btn-flat">
                <i class="fa fa-check"></i>
                {{ trans('app.admin.menu.save') }}
            </button>
        </a>
    </div>
</form>