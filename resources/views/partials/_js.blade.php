<script type="text/javascript" src="{{ URL::asset('assets/lib/jquery/js/jquery-3.5.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/popover/js/popover.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/validation/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/validation/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/validation/localization/messages_lt.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/nestable/js/jquery.nestable.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/select2/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/select2/js/select2_lang_lt.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/pnotify/js/PNotify.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/pnotify/js/PNotifyButtons.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/lib/nonblock/js/NonBlock.js') }}"></script>
{{--<script type="text/javascript" src="{{ URL::asset('assets/lib/jquery-ui/js/interactions.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ URL::asset('assets/lib/jquery-ui/js/touch.min.js') }}"></script>--}}

<script type="text/javascript" src="{{ URL::asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/editor.js') }}"></script>

<script type="text/javascript" src="{{ URL::asset('js/validate.js?v=' . filemtime('js/validate.js')) }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/nestable.js?v=' . filemtime('js/nestable.js')) }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/listing.js?v=' . filemtime('js/listing.js')) }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/modal.js?v=' . filemtime('js/modal.js')) }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js?v=' . filemtime('js/app.js')) }}"></script>

@include('partials._js_globals')
