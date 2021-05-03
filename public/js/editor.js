/**
 * tinymce editors stettings globaly
 *
 * New styles for custom editors goes here
 */
$(function () {
    tinymce.init({
        selector: 'textarea.basic-text-editor',
        language: 'lt',
        statusbar: false,
        height: 600,
        convert_urls: false,
        remove_script_host: false,
        forced_root_block: "",
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image ' +
            'link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools ' +
            'textpattern noneditable help charmap quickbars emoticons',
        imagetools_cors_hosts: [
            'picsum.photos'
        ],
        menubar: 'file edit view insert format tools table help',
        toolbar: 'acelletags | undo redo | bold italic underline strikethrough | fontsizeselect formatselect | ' +
            'alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | ' +
            'pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample ' +
            '| ltr rtl',
        toolbar_sticky: true,
        toolbar_mode: 'sliding',
        valid_elements: '*[*],meta[*]',
        extended_valid_elements: "meta[*]",
        valid_children: "+body[style],+body[meta],+div[h2|span|meta|object],+object[param|embed]",
        content_css: [
            APP_URL.replace('/index.php', '') + '/assets/lib/tinymce/skins/lightgray/content.fixed.css?' + new Date().getTime(),
            APP_URL.replace('/index.php', '') + '/assets/lib/font-awesome/css/font-awesome.min.css?' + new Date().getTime(),
        ],
        external_filemanager_path: APP_URL.replace('/index.php', '') + "/filemanager2/",
        filemanager_title: LANG_FILEMANAGER_TITLE,
        external_plugins: {
            "filemanager": APP_URL.replace('/index.php', '') + "/filemanager2/plugin.min.js"
        },
        setup: function (editor) {
            editor.on('change keyup', function(e){
                editor.save(); // updates this instance's textarea
                $(editor.getElement()).trigger('change'); // for garlic to detect change
            });
        }
    });
});
