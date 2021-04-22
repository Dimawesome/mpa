<script>
    let APP_URL = '{{ url('/') }}',
        CSRF_TOKEN = '{{ csrf_token() }}',
        LANG_NOTIFY = {
            'success': '{{ trans('app.notify.success') }}',
            'error': '{{ trans('app.notify.error') }}',
            'notice': '{{ trans('app.notify.notice') }}',
            'check_try_again': '{{ trans('app.check_entry_try_again') }}'
        },
        POPOVER = {
            'yes': '{{ trans('app.popover.yes') }}',
            'no': '{{ trans('app.popover.no') }}'
        }

    {{--var LANG_FILE_INPUT = '{{ trans('app.no_file_selected') }}';--}}
    {{--var LANG_FILEMANAGER_TITLE = '{{ trans('app.file_manager_title') }}';--}}
    {{--var FILE_UPDATED = '{{ trans('app.file_updated') }}';--}}
    {{--var SOMETHING_WENT_WRONG = '{{ trans('app.something_went_wrong') }}';--}}
</script>
