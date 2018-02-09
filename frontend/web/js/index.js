$(document).ready(function(){
    $('.nextTest').click(function() {
        if ($('.test-block:visible input[type="radio"]:checked').length){
            $('.test-block:visible').hide().next('.test-block').show();
        }
    });
    $('.nextTestAdmin').click(function(){
        $('.test-block-admin:visible').hide().next('.test-block-admin').show();
    });
    $('.prevTestAdmin').click(function(){
        $('.test-block-admin:visible').hide().prev('.test-block-admin').show();
    });
    modal('.editQuestion', '#modal-editQuestion');
    modal('.editTitle', '#modal-editQuestion');

    valueRadio('.answer-1', '.radio-1');
    valueRadio('.answer-2', '.radio-2');
    valueRadio('.answer-3', '.radio-3');
    valueRadio('.answer-4', '.radio-4');
    function modal(id, value) {
        $(id).click(function(){
            let path = $(this).data('path');
            $(value).modal('show')
                .find('.modal-content')
                .load(path);
        });
    }

    function valueRadio(answer, radio){
       $('body').on('change', answer, function () {
           let value = $(this).val();
           $(radio).attr('value', value)
       })
    }
});