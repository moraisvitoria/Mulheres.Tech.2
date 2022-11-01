changeTitle('Login / Entrar');
if (getCookie(app.cookie + '_user') != '') loadPage('home');

$('#logginForm').submit(goLogin);

function goLogin() {
    slideMsg(spinner, 10000);

    const login = {
        email: $('#email').val().trim().toLowerCase(),
        password: $('#password').val().trim(),
        logged: $('#logged').is(':checked')
    }

    $.post(`${app.api}/login.php`, login)
        .done((data) => {
            let jData = JSON.parse(data);
            if (jData.return == 'error') slideMsg(jData.value);
            else {
                slideMsg(jData.value);
                let uData = getCookie(app.cookie + '_user');
                uData = JSON.parse(uData);
                $('a[href="user"]').html(`<img src="${uData.photo}" alt="Perfil de ${uData.name}." title="Perfil de ${uData.name}.">`);
                loadPage('home');
            }
        });

    return false;
}

