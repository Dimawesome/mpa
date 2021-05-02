<form method="POST" id="modal-form" class="form-validate-jquery">
    @csrf

    <input type="hidden" name="_method" value="PATCH">
    <input type="hidden" name="order" value="{{ $menu['order'] }}">
    <input type="hidden" name="muid" value="{{ $menu['uid'] }}">

    @include('admin.menu_items._form')

    <div class="modal-footer text-center d-block">
        <a href="{{ action('Admin\MenuItemController@update') }}"
           class="modal-submit" data-method="POST">
            <button class="btn btn-purple">
                <em class="fa fa-check"></em>
                {{ trans('app.admin.save') }}
            </button>
        </a>
    </div>
</form>