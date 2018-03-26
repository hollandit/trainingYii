$(document).ready(function () {
    let url = window.location.origin;
    $('#form-condition').submit(function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.post({
            url: `${url}/frontend/web/test/condition?id=${id}`,
            data: $(this).serialize(),
        }).done(() => {
            $('#editCondition').modal('hide');
            $.pjax.reload('#pjax-condition');
        })
            .fail(err => console.log(err.responseText))
    });
    $('body').on('submit', '#create-shifts', function (e) {
        e.preventDefault();
        send(`${url}/frontend/web/shifts/create`, $(this).serialize());
    });
    $('body').on('submit', '#edit-shifts', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        send(`${url}/frontend/web/shifts/update?id=${id}`, $(this).serialize());
    });

    function send(url, data) {
        console.log(url);
        $.post({
                url: url,
                data: data
            })
                .done(() => {
                    $('#modal-createShifts').modal('hide');
                    $.pjax.reload('#pjax-shifts');
                })
                .fail(err => console.log(err.responseText))
    }
});