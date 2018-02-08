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
    $('.editQuestion').click(function(){
        var path = $(this).data('path');
        $('#modal-editQuestion').modal('show')
            .find('.modal-content')
            .load(path);
    });
    // $('body').on('change', '.answer-1', function () {
    //     let value = $(this).val();
    //     $('.radio-1').attr('value', value)
    // })
    valueRadio('.answer-1', '.radio-1');
    valueRadio('.answer-2', '.radio-2');
    valueRadio('.answer-3', '.radio-3');
    valueRadio('.answer-4', '.radio-4');

    function valueRadio(answer, radio){
       $('body').on('change', answer, function () {
           let value = $(this).val();
           $(radio).attr('value', value)
       })
    }
});