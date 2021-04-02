<form action="{{ action("Admin\MenuController@update", $menu->uid) }}" id="modal-form" method="POST"
      class="form-validate-jquery">
    @csrf
    <input type="hidden" name="_method" value="PATCH">

    @include('admin.menu._form')

    <div class="modal-footer text-center">
        <a href="{{ action('ModuleController@storeModule') }}"
           class="modal-submit module-submit" data-method="POST">
            <button class="btn btn-burgundy btn-flat">
                <i class="fa fa-check"></i>
                {{ trans('app.save') }}
            </button>
        </a>
    </div>
</form>