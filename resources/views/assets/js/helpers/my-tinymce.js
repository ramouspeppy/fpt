export async function myTinyMce(selector, height = 240) {
    const tinymce = (await import("tinymce")).default;

    await Promise.all([
        import("tinymce/icons/default"),
        import("tinymce/themes/silver"),
        import("tinymce/plugins/advlist"),
        import("tinymce/plugins/autolink"),
        import("tinymce/plugins/lists"),
        import("tinymce/plugins/link"),
        import("tinymce/plugins/image"),
        import("tinymce/plugins/charmap"),
        import("tinymce/plugins/print"),
        import("tinymce/plugins/preview"),
        import("tinymce/plugins/hr"),
        import("tinymce/plugins/anchor"),
        import("tinymce/plugins/pagebreak"),
        import("tinymce/plugins/searchreplace"),
        import("tinymce/plugins/wordcount"),
        import("tinymce/plugins/visualblocks"),
        import("tinymce/plugins/visualchars"),
        import("tinymce/plugins/code"),
        import("tinymce/plugins/fullscreen"),
        import("tinymce/plugins/insertdatetime"),
        import("tinymce/plugins/media"),
        import("tinymce/plugins/nonbreaking"),
        import("tinymce/plugins/save"),
        import("tinymce/plugins/table"),
        import("tinymce/plugins/directionality"),
        import("tinymce/plugins/emoticons"),
        import("tinymce/plugins/template"),
        import("tinymce/plugins/paste"),
        import("tinymce/plugins/textpattern"),
        import("tinymce/plugins/quickbars"),

        // Load CSS Skin
        import("tinymce/skins/ui/oxide/skin.min.css"),
    ]);

    tinymce.init({
        path_absolute: "/",
        selector: selector,
        height: height,
        relative_urls: false,
        base_url: "/tinymce",
        suffix: ".min",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern quickbars",
        ],
        toolbar_mode: "sliding",
        quickbars_selection_toolbar:
            "bold italic | quicklink h2 h3 h4 alignleft aligncenter alignright alignjustify blockquote quickimage quicktable",
        quickbars_insert_toolbar: false,
        toolbar:
            "fullscreen undo redo | fontselect fontsizeselect formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",

        image_class_list: [
            {
                title: "Image Responsive",
                value: "img-fluid",
            },
        ],

        file_picker_callback: function (callback, value, meta) {
            let x =
                window.innerWidth ||
                document.documentElement.clientWidth ||
                document.body.clientWidth;
            let y =
                window.innerHeight ||
                document.documentElement.clientHeight ||
                document.body.clientHeight;

            let cmsURL = "/laravel-filemanager?editor=" + meta.fieldname;
            if (meta.filetype === "image") {
                cmsURL += "&type=Images";
            } else {
                cmsURL += "&type=Files";
            }

            tinymce.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: "Filemanager",
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                },
            });
        },
    });
}

export async function myTinyMceLite(selector, height = 180) {
    const tinymce = (await import("tinymce")).default;

    await Promise.all([
        import("tinymce/icons/default"),
        import("tinymce/themes/silver"),
        import("tinymce/plugins/link"),
        import("tinymce/plugins/lists"),
        import("tinymce/plugins/code"),
        import("tinymce/plugins/paste"),
        import("tinymce/plugins/autolink"),
        import("tinymce/skins/ui/oxide/skin.min.css"),
    ]);

    tinymce.init({
        selector: selector,
        height: height,
        menubar: false,
        relative_urls: false,
        plugins: "link lists code paste autolink table wordcount fullscreen",

        toolbar: `
            undo redo | formatselect |
            bold italic underline |
            alignleft aligncenter alignright |
            bullist numlist |
            link table |
            removeformat | code fullscreen
        `,

        paste_as_text: true,
        branding: false,

        paste_as_text: true,
        base_url: "/tinymce",
        suffix: ".min",
    });
}
