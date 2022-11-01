changeTitle('Editar Shortlink');
if (getCookie(app.cookie + '_user') == '') loadPage('login');

var id = parseInt(getCookie(app.cookie + '_shortId'));
if (id == 0 || id == NaN) slideMsg('Erro!<br>Selecione um shortlink...');
else {
    slideMsg(spinner, 10000);
    $('#shortlink span').html(app.url + '/');
    $.post(`${app.api}/get.php`, { id: id })
        .done((data) => {
            let jData = JSON.parse(data);
            if (jData.return == 'error') {
                slideMsg(jData.value);
                switch (jData.id) {
                    case 5: loadPage('login'); break;
                    case 10: loadPage('home'); break;
                }
            } else {
                if (parseInt(jData.value.counter) > 10) $('#editAlert').show();
                if (jData.value.mode == 'url') $('#modeURL').prop("checked", true);
                else $('#mode301').prop("checked", true);
                if (jData.value.status == 'on') $('#statusOn').prop("checked", true);
                else $('#statusOff').prop("checked", true);
                for (const [key, value] of Object.entries(jData.value)) $(`#${key}`).val(value);
                $('#editForm #url').change(() => getField('url', $('#editForm #url').val().trim(), id));
                $('#editForm #short').change(() => getField('short', $('#editForm #short').val().trim(), id));
                $('button[type=reset]').click(() => loadPage('edit'));
                $('#editForm').submit(saveShortLink);
                slideMsg('', 0);
            }
        });
}

function saveShortLink() {
    slideMsg(spinner, 10000);
    var formData = $('#editForm').serializeArray();
    var formObject = {};

    $.each(formData,
        function (i, v) {
            formObject[v.name] = v.value;
        });
    formObject['user'] = user.id;

    $.post(`${app.api}/edit.php`, formObject)
        .done((data) => {
            let jData = JSON.parse(data);
            if (jData.return == 'error') {
                slideMsg(jData.value);
                switch (jData.id) {
                    case 5: loadPage('login'); break;
                    case 10: loadPage('home'); break;
                }
            } else {
                slideMsg(jData.value);
                loadPage('home');
            }
        });
    return false;
}
