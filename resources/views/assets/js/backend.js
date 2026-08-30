$('[data-toggle="tooltip"]').tooltip();
// copy js
$(".btn").tooltip({
    trigger: "click",
    placement: "bottom",
});

$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
// $(".select2").select2();
// $(".select2-tags").select2({
//     tags: true,
//     tokenSeparators: [','],
// });

function setTooltip(btn, message) {
    $(btn).tooltip("hide").attr("data-original-title", message).tooltip("show");
}

function hideTooltip(btn) {
    setTimeout(function () {
        $(btn).tooltip("hide");
    }, 1000);
}

// var clipboard = new ClipboardJS('.btn');

// clipboard.on('success', function (e) {
//     setTooltip(e.trigger, 'Copied!');
//     hideTooltip(e.trigger);
// });

// clipboard.on('error', function (e) {
//     setTooltip(e.trigger, 'Failed!');
//     hideTooltip(e.trigger);
// });
// end copy js

$("table").on("draw.dt", function () {
    $('[data-toggle="tooltip"]').tooltip();
    $(".star").rating({
        theme: "krajee-fas",
        containerClass: "is-star",
        showCaption: false,
        displayOnly: true,
        size: "xs",
    });
});
// Card Progress Controller
// $.simpleCardProgress = function (card) {
//     var me = $(card);
//     me.addClass("card-progress");
// };

// $.myTinyMce = function (selector, height = 240) {
//     var editor_config = {
//         path_absolute: "/",
//         selector: selector,
//         relative_urls: false,
//         plugins: [
//             "advlist autolink lists link image charmap print preview hr anchor pagebreak",
//             "searchreplace wordcount visualblocks visualchars code fullscreen",
//             "insertdatetime media nonbreaking save table directionality",
//             "emoticons template paste textpattern quickbars"
//         ],
//         toolbar_mode: 'sliding',
//         quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 h4 alignleft aligncenter alignright alignjustify blockquote quickimage quicktable',
//         quickbars_insert_toolbar: false,
//         toolbar: "fullscreen undo redo | fontselect fontsizeselect formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",

//         file_picker_callback: function (callback, value, meta) {
//             var x = window.innerWidth || document.documentElement.clientWidth || document
//                 .getElementsByTagName(
//                     'body')[0].clientWidth;
//             var y = window.innerHeight || document.documentElement.clientHeight || document
//                 .getElementsByTagName('body')[0].clientHeight;

//             var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta
//                 .fieldname;
//             if (meta.filetype == 'image') {
//                 cmsURL = cmsURL + "&type=Images";
//             } else {
//                 cmsURL = cmsURL + "&type=Files";
//             }

//             tinyMCE.activeEditor.windowManager.openUrl({
//                 url: cmsURL,
//                 title: 'Filemanager',
//                 width: x * 0.8,
//                 height: y * 0.8,
//                 resizable: "yes",
//                 close_previous: "no",
//                 onMessage: (api, message) => {
//                     callback(message.content);
//                 }
//             });
//         },
//         image_class_list: [{
//             title: 'Image Responsive',
//             value: 'img-fluid'
//         }],
//         height: height
//     };

//     tinymce.init(editor_config);
// }

// lazy load

// document.addEventListener('DOMContentLoaded', async () => {
//     const editorContainer = document.getElementById('editor'); // pastikan ada <div id="editor"></div>
//     if (!editorContainer) return;

//     // Lazy load CodeMirror
//     const CodeMirror = (await import('codemirror')).default;

//     // Import mode & addon tambahan
//     await import('codemirror/mode/javascript/javascript');
//     await import('codemirror/addon/selection/active-line');

//     const editor = CodeMirror(editorContainer, {
//         lineNumbers: true,
//         mode: "javascript",
//         styleActiveLine: true,
//         theme: "default",
//     });
// });
