$(function(){
    var logoInp = $('#J_InfoLogo'),
        logoUpload = $('#J_UploadLogo'),
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
                    logoInp.val(res.file.path);
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