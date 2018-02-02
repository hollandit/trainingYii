$(document).ready(function(){
    $('.nextTest').click(function() {
        if ($('.test-block:visible input[type="radio"]:checked').length){
            $('.test-block:visible').hide().next('.test-block').show();
        }
    });
});