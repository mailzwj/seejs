$(function(){
    var editor = editormd('J_ArticleMain', {
        path: '../assets/plugins/editormd/lib/',
        width: 900,
        height: 450,
        watch: false,
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

    var submitBtn = $('#J_SaveArticle'),
        conBox = $('#J_HtmlContent'),
        oForm = $('#J_ArticleForm');
    // submitBtn.on('click', function(){
    //     conBox.val(editor.getHTML());
    // });
    oForm.on('submit', function(){
        conBox.val(editor.getHTML());
    });
    
    var back = $("#J_BackList");
    back.on('click', function(){
        history.go(-1);
    });
});
