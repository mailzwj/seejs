$(function(){


    var artId = $('#J_ArtId').val();

    $('body').find('pre').addClass('prettyprint linenums');
    PR.prettyPrint();
    // hljs.initHighlighting();

    $('.J_ArtPraise').on('click', function(ev){
        ev.preventDefault();
        var _this = $(this),
            api = _this.attr('href');
        $.ajax({
            url: api,
            type: 'get',
            dataType: 'jsonp',
            data: {
                id: artId
            },
            success: function(data) {
                if (data.result) {
                    console.log(data.message);
                    _this.find('.J_PraiseNum').html(data.count);
                } else {
                    throw('Error: ' + data.message);
                }
            }
        });
    });
});