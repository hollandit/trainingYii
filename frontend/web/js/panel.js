$(document).ready(function () {
    let urlSite = window.location.origin;
    create('action-contact', 'save-contact', 'frontend/web/user/update-contact?id');
    create('action-info', 'save-info', 'frontend/web/user/update-info?id');
    edit('save-contact', 'action-contact', 'frontend/web/user/update-contact?id');
    edit('save-info', 'action-info', 'frontend/web/user/update-info?id');
    function create(contact, save, url) {
        $('body').on('click', `.${contact}`, function(){
            let id = $(this).data('id');
            let panel = $(this).next();
            $( `.${contact}` ).removeClass( `glyphicon-pencil ${contact}` ).addClass( `glyphicon-floppy-disk ${save}` );
            $.get({
                url: `${urlSite}/${url}=${id}`
            })
                .done(res => {
                    res = JSON.parse(res);
                    if (contact === 'action-contact'){
                        panel.find('.employee-table_email').html(`<input type="email" name="email" required value="${res.email}" class="employee-edit_email">`);
                        panel.find('.employee-table_phone').html(`<input type="text" name="phoen" required value="${res.phone}" class="employee-edit_phone">`);
                    } else {
                        let option = res.allPosition.map(position => {
                            let selected = position.id === res.position ? 'selected' : '';
                            return `<option value="${position.id} ${selected}">${position.name}</option>`
                        });
                        panel.find('.employee-table_salary').html(`<input type="text" name="salary" required value="${res.salary}" class="employee-edit_salary">`);
                        panel.find('.employee-table_position').html(`<select class="employee-edit_position">${option}</select>`);
                    }
                })
                .fail(err => console.log(err));
        });
    }
    function edit(save, action, url){
        $('body').on('click', `.${save}`, function () {
            let id = $(this).data('id');
            let data = {};
            if(save === 'save-contact'){
                data = {
                    email: $('.employee-edit_email').val(),
                    phone: $('.employee-edit_phone').val()
                }
            } else {
                data = {
                    salary: $('.employee-edit_salary').val(),
                    position: $('.employee-edit_position').val()
                }
            }
            $.post({
                data: data,
                url: `${urlSite}/${url}=${id}`
            })
                .done(item => {
                    item = JSON.parse(item);
                    if (save === 'save-contact'){
                        $('.employee-edit_email').replaceWith(item.email);
                        $('.employee-edit_phone').replaceWith(item.phone);
                    } else {
                        $('.employee-edit_salary').replaceWith(`${item.salary} <span class="glyphicon glyphicon-ruble"></span>`);
                        $('.employee-edit_position').replaceWith(item.position);
                    }
                    $(`.${save}`).removeClass( `glyphicon-floppy-disk ${save}` ).addClass( `glyphicon-pencil ${action}` )
                })
                .fail(err => console.log(err.responseText));
        });
    }
});