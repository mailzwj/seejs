$(function(){
    var win = $(window),
        rTit = $('#J_RightTitle'),
        frame = $('#J_AdminIframe'),
        menuWrap = $('#J_ManageMenus');

    frame.css('height', win.height() - rTit.outerHeight());

    win.on('resize', function(){
        frame.css('height', win.height() - rTit.outerHeight());
    });

    menuWrap.on('click', '.menu', function(){
        menuWrap.find('.active').removeClass('active');
        $(this).addClass('active');
    });
});