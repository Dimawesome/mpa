<script>
    let APP_URL = '{{ url('/') }}',
        CSRF_TOKEN = '{{ csrf_token() }}',
        LANG_NOTIFY = {
            'success': '{{ trans('app.notify.success') }}',
            'error': '{{ trans('app.notify.error') }}',
            'notice': '{{ trans('app.notify.notice') }}',
            'check_try_again': '{{ trans('app.notify.check_entry_try_again') }}'
        },
        POPOVER = {
            'yes': '{{ trans('app.popover.yes') }}',
            'no': '{{ trans('app.popover.no') }}'
        },
        SOMETHING_WENT_WRONG = '{{ trans('app.notify.something_went_wrong') }}',
        LANG_FILE_INPUT = '{{ trans('app.no_file_selected') }}',
        LANG_FILEMANAGER_TITLE = '{{ trans('app.admin.module.file_manager_title') }}',
        FILE_UPDATED = '{{ trans('app.admin.module_file.updated') }}';
</script>
