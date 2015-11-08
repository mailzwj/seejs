$(function(){
    var editor = editormd('J_ArticleMain', {
        path: '../assets/plugins/editormd/lib/',
        width: 900,
        height: 450,
        watch: false,
        htmlDecode: 'script,iframe,embed,object|on*',
        saveHTMLToTextarea: true,
        toolbarIcons: function() {
            // return editormd.toolbarModes['simple'];
            return ['undo', 'redo', '|',
                'bold', 'del', 'italic', 'quote', '|',
                'h1', 'h2', 'h3', 'h4', '|',
                'list-ul', 'list-ol', '|',
                'link', 'reference-link', 'image', 'code', 'code-block', 'table', '||',
                'preview', 'help', 'info'
            ];
        }
    });

    var conBox = $('#J_HtmlContent'),
        oForm = $('#J_ArticleForm');
    oForm.on('submit', function(){
        conBox.val(editor.getHTML());
    });
    
    var back = $("#J_BackList");
    back.on('click', function(){
        history.go(-1);
    });

    var banInp = $('#J_ArticleBanner'),
        logoUpload = $('#J_UploadBanner'),
        rImg = /^image\/(png|jpe?g|gif)$/g;

    function sendFile(file) {
        var xhr = new XMLHttpRequest(),
            fd = new FormData(),
            res = null;
        fd.append('image', file);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                res = $.parseJSON(xhr.responseText);
                if (res.result) {
                    banInp.val(res.file.path);
                } else {
                    throw('Error: ' + res.message);
                }
            }
        };
        xhr.open('POST', './upload.php');
        xhr.send(fd);
    }

    logoUpload.on('change', function(){
        var file = this.files[0],
            ftype = file.type;
        if (!ftype.match(rImg)) {
            throw('Error: ' + ftype + ' not surported.');
            return false;
        }
        sendFile(file);
    });
});
