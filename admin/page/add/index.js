changeTitle('Novo Shortlink');
var user = getCookie(app.cookie + '_user');
if (user == '') loadPage('login');
else user = JSON.parse(user);

$('#shortlink span').html(app.url + '/');
 
$('#expires').val(today(3650));

$('#addForm #url').change(() => {
    if ($('#addForm #url').is(':valid')) {
        getField('url', $('#addForm #url').val().trim(), 0);
    }
});

$('#addForm #name').focus(() => {
    if ($('#addForm #url').is(':valid') && $('#addForm #url').attr('class') != 'invalid') {
        slideMsg(spinner, 10000);
        $.post(`${app.api}/title.php`, { url: $('#addForm #url').val().trim() })
            .done((data) => {
                let jData = JSON.parse(data);
                if (jData.return == 'error') slideMsg(jData.value);
                else $('#addForm #name').val(jData.value.title);
            });
    }
});

$('#addForm #short').change(() => {
    if ($('#addForm #short').is(':valid')) {
        getField('short', $('#addForm #short').val().trim(), 0);
    }
});
$('#addForm').submit(createShortLink);

function createShortLink() {
    slideMsg(spinner, 10000);

    var formData = $('#addForm').serializeArray();
    var formObject = {};
   
    $.each(formData,
        function (i, v) {
            formObject[v.name] = v.value;
        });
    formObject['user'] = user.id;

    $.post(`${app.api}/add.php`, formObject)
        .done((data) => {
            console.log(data);
            let jData = JSON.parse(data);
            if (jData.return == 'error') {
                slideMsg(jData.value);
            } else {
                slideMsg(jData.value);
                loadPage('home');
            }
        });
    return false;
}

