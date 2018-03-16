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
    })
});