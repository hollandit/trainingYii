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
});