$(function (){
    $('.tree-list a.channel-header').click(function (e) {
        e.preventDefault()
    })

    $('.tree-list .channel-description').tooltip({
        html: true,
        placement: 'right'
    });

    $('.tree-list .data.collapse').on('show.bs.collapse hide.bs.collapse', function (e) {
        e.stopPropagation();
        $(this).parent().children('i.collapse-caret').toggleClass('fa-caret-down fa-caret-right');
    });
})
