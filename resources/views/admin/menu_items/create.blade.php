<form method="POST" id="modal-form" class="form-validate-jquery">
    @csrf

    @include('admin.menu_items._form')

    <div class="modal-footer text-center d-block">
        <a href="{{ action('Admin\MenuItemController@store') }}"
           class="modal-submit" data-method="POST" data-overlay-id="menu-modal-loader">
            <button class="btn btn-purple">
                <em class="fa fa-check"></em>
                {{ trans('app.admin.save') }}
            </button>
        </a>
    </div>

    @include('partials._html_loader', ['id' => 'menu-modal-loader'])
</form>
