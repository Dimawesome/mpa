<!-- Basic modal -->
<div id="baseModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body"></div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
<!-- /basic modal -->

<!-- Basic modal -->
<div id="link_confirm_model" class="modal mc-modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="confirm-link-form" onkeypress="return event.keyCode !== 13;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">{{ trans('app.are_you_sure') }}</h4>
                </div>
                <div class="modal-body">
                    <h6></h6>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn bg-grey"
                            data-dismiss="modal">{{ trans('app.cancel') }}</button>
                    <a class="btn btn-burgundy btn-flat link-confirm-button ajax_link">{{ trans('app.confirm') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /basic modal -->

<!-- Basic modal -->
<div id="delete_confirm_model" class="modal fade new-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="confirm-delete-form form-validate-jquery" onkeypress="return event.keyCode !== 13;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">{{ trans('app.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h6 class="mt-0"></h6>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn bg-grey" data-dismiss="modal">{{ trans('app.cancel') }}</button>
                    <a class="btn btn-danger btn-flat delete-confirm-button ajax_link">{{ trans('app.delete') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /basic modal -->

<!-- Form confirm modal -->
<div id="form_confirm_model" class="modal mc-modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="confirm-link-form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">{{ trans('app.are_you_sure') }}</h4>
                </div>
                <div class="modal-body">
                    <h6></h6>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn bg-grey"
                            data-dismiss="modal">{{ trans('app.cancel') }}</button>
                    <a class="btn btn-burgundy btn-flat form-confirm-button">{{ trans('app.confirm') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /form confirm modal  -->
