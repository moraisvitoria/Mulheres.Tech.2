changeTitle('Usuário');
var user = getCookie(app.cookie + '_user');
if (user == '') loadPage('login');
else user = JSON.parse(user);

var html = `
<img src="${user.photo}" alt="${user.name}" title="${user.name}">
<h3>${user.name}</h3>
<ul>
    <li><strong>E-mail: </strong>${user.email}</li>
</ul>

<div class="btns">
    <button type="button" id="userEdit">Editar perfil</button>
    <button type="button" id="userPass">Trocar senha</button>
    <button type="button" id="userLogout">Logout / Sair</button>
</div>
`;

$('#userData').html(html);
$('#userEdit').click(() => {
    console.log('Editar perfil');
});

$('#userPass').click(() => {
    console.log('Trocar senha');
});

$('#userLogout').click(() => {
    msg = `
<h3>Oooops!</h3>Tem certeza que deseja sair do aplicativo?
<p class="confirm-buttons">
    <button class="confirm">Sim, sair</button>
    <button class="reset">Cancelar</button>
</p>        
        `;
    slideMsg(msg, 15000);
    $('.confirm-buttons button').click(logOut);
});

function logOut() {
    slideMsg('', 0);
    if ($(this).attr('class') == 'confirm') {
        $('a[href="user"]').html(`<i class="fa-solid fa-user fa-fw"></i>`);
        setCookie(app.cookie + '_user', '', -10);
        setCookie(app.cookie + '_shortId', '', -10);
        setCookie(app.cookie + '_options', '', -10);
        setCookie(app.cookie + '_short', '', -10);
        slideMsg('Ok!<br>Sessão encerrada...');
        loadPage('login');
    }
}
