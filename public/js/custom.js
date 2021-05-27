jQuery(document).ready(function ($) {
    $('.confirmDelete').on('click', function (e) {
        let form = $(this).data('form');
        e.preventDefault();
        alertify.confirm('Вы уверены?', function () {
            $('#'+form).submit();
        })
    })
    $('.confirm').on('click', function(e){
        e.preventDefault()
        let $this = $(this);
        alertify.confirm('Вы уверены?', function(){
            $this.parents('form').unbind('submit').submit();
        }, function(){})
    })

    $('.openProducts').on('click', function (e) {
        e.preventDefault();
        $('.child-elements').fadeOut('fast')
        let child = $(this).parents('tr').next('tr.child-elements');
        if (child.is(':hidden')){
            child.fadeIn('fast')
        }else{
            child.fadeOut('fast')
        }
    })
})
$(function () {
    $('[data-toggle="popover"]').popover()
})
