$(document).ready(function(){
    //navigation question
    $('.nextTest').click(function() {
        if ($('.test-block:visible input[type="radio"]:checked').length){
            $('.test-block:visible').hide().next('.test-block').show();
        }
    });
    $('.nextTestAdmin').click(function(){
        $('.test-block-admin:visible').hide().next('.test-block-admin').show();
    });
    $('.nextTestAdminSecond').click(function(){
        $('.test-block-admin:visible').hide().next('.test-block-admin').show();
    });
    $('.prevTestAdmin').click(function(){
        $('.test-block-admin:visible').hide().prev('.test-block-admin').show();
    });
    //The delete button appears in the list
    $('li.navigation-menu').hover(function(){
        $(this).append($('<span class="buttonNavDelete glyphicon glyphicon-remove-sign" data-id="'+$(this).data('id')+'"></span>'));
    }, function () {
        $(this).find('span:last').remove();
    });

    //Modal view
    $('body').on('click', '.buttonNavDelete',function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        console.log(id);
        let div = document.createElement('div');
        div.className = 'delete-modal';
        div.onclick = function (e) {
            let t = e ? e.target : window.event.srcElement;
            if(t.tagName === 'INPUT'){
                t.value === 'Да, уверен' && window.location.replace('http://hosttraining/frontend/web/index.php?r=test%2Fdelete-theme&id='+id);
                this.parentNode.removeChild(this);
            }
        };
        div.innerHTML='<div><h1>Уверены?...</h1><br/><p>Это действие необратим. Если Вы сейчас удалите тест, то уже не сможете его восстановить.</p></div><input type="button" value="Отменить"><input type="button" class="delete-button" value="Да, уверен">';
        return document.body.appendChild(div);
    });

    modal('.editQuestion', '#modal-editQuestion');
    modal('.editTitle', '#modal-editQuestion');

    // of input put value in radio
    valueRadio('.answer-1', '.radio-1');
    valueRadio('.answer-2', '.radio-2');
    valueRadio('.answer-3', '.radio-3');
    valueRadio('.answer-4', '.radio-4');

    //function
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