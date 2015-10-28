$(function(){
    var editor = editormd('J_ArticleMain', {
        path: '../assets/plugins/editormd/lib/',
        width: 900,
        height: 450,
        watch: false,
        saveHTMLToTextarea: true,
        toolbarIcons: function() {
            return editormd.toolbarModes['simple'];
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
