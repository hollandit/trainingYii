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

    $('.test-answer').click(function () {
        $('.answerButton').trigger('click');
    });

    $('.test-title').tooltip({
        placement: 'bottom'
    });
    //Form test
    $('#testForm-result').submit(function(e){
        e.preventDefault();
        let id = $(this).data('id');
        let form = $(this).serialize();
        $.post({
            url: 'http://hosttraining/frontend/web/index.php?r=test%2Ftesting&id='+id,
            data: form,
        })
            .done(data => {
                let result = JSON.parse(data);
                $('#modalResult').modal('show');
                $('#modalResult').on('hide.bs.modal', function () {
                    window.location.replace('http://hosttraining/frontend/web/index.php?r=site%2Findex');
                });
                if (result.status === 1){
                    clearInterval(intervalID);
                    $('.modal-result_test').html('<div class="modal-result_title">Поздравляем Вас с успешным прохождением теста!<br/>' +
                        'Количество допустимых ошибок: 2.</div><div class="modal-result_information">Это неплохой результат.<br>' +
                        'Этот тест Вы сможете пройти не раньше, чем через 2 недели.<br>' +
                        'Однако, Вы можете запросить более сложный.</div><div class="modal-result_information">' +
                        'Дерзайте!' +
                        '</div>')
                } else {
                    clearInterval(intervalID);
                    $('.modal-result_test').html('<div class="modal-result_title">К сожалению, Вы не прошли тест.<br/>' +
                        '</div><div class="modal-result_information">Это плохой результат.<br>' +
                        'Этот тест Вы сможете пройти не раньше, чем через 2 недели.<br>' +
                        'Рекомендую Вам не тратить это время зря и основательно подготовиться.</div><div class="modal-result_information">' +
                        'Успехов!' +
                        '</div>')
                }
            })
            .fail(err => console.log(err.responseText));
    });

    //FileImage
    $('body').on('change', '.test-created-input', function(){
        $('.test-created-span').remove();
        uploadFile(this, '.test-created-image');
    });

    //Modal view
    $('body').on('click', '.buttonNavDelete',function (e) {
        e.preventDefault();
        let id = $(this).data('id');
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

    $('#completion-button').click(function (e) {
        e.preventDefault();
        let div = document.createElement('div');
        div.className = 'completion-modal';
        div.onclick = function (e) {
            let t = e ? e.target : window.event.srcElement;
            if(t.tagName === 'INPUT'){
                t.value === 'Завершить' && window.location.replace('http://hosttraining/frontend/web/index.php?r=site%2Findex');
                this.parentNode.removeChild(this);
            }
        };
        div.innerHTML='<div><h1>Уверены?...</h1><br/><p>Если Вы завершите тест сейчас, то он будет считаться непройденным. Это отрицательно отразится на Вашем рейтинге.</p></div><input type="button" value="Вернуться к тесту"><input type="button" class="completion-button" value="Завершить">';
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

    function uploadFile(input, className){
        if(input.files && input.files[0]){
            let reader = new FileReader();

            reader.onload = (e) => {
                $(className).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
});