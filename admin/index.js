$(document).ready(runApp);

var app = {
    url: window.location.origin,
    api: `${window.location.origin}/api`,
    name: 'Luferat Shortner',
    cookie: 'Luferat_Redir',
}
var vRoutes = ['', 'add', 'edit', 'home', 'login', 'qrcode', 'user'];
var spinner = '<i class="fa fa-spinner fa-spin"></i>';
var user = getCookie(app.cookie + '_user');

if (user != '') {
    user = JSON.parse(user);
    $('a[href="user"]').html(`<img src="${user.photo}" alt="Perfil de ${user.name}." title="Perfil de ${user.name}.">`);
} else {
    $('a[href="user"]').html(`<i class="fa-solid fa-user fa-fw"></i>`);
}

function runApp() {
    let route = location.href.split('/')[location.href.split('/').length - 1].trim();
    if (route == '') route = 'home';
    if (vRoutes.includes(route)) loadPage(route);
    else location.href = '/404.html';
    $(document).on('click', 'a', routerLink);
}

function routerLink() {
    let href = $(this).attr('href').trim().toLowerCase();
    if (
        href.substring(0, 7) == 'http://' ||
        href.substring(0, 8) == 'https://' ||
        href.substring(0, 1) == '#' ||
        $(this).attr('target') == '_blank'
    ) return true;

    if (href == 'copy') {
        let short = $(this).attr('data-short').trim();
        navigator.clipboard.writeText(short);
        slideMsg('Link copiado...');
        return false;
    }
    loadPage(href);
    return false;
}

function loadPage(href) {
    let page = {
        html: `page/${href}/index.html`,
        css: `page/${href}/index.css`,
        js: `page/${href}/index.js`,
    }
    $.get(page.html, (html) => {
        $('#pageCSS').attr('href', page.css);
        $('main').html(html);
        $.getScript(page.js);
        localStorage.setItem('route', href);
        window.history.pushState({}, "", href);
    });
}

function changeTitle(title = '') {
    if (title == '') title = `${app.name}`;
    else title = `${app.name} • ${title}`;
    $('title').html(title);
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function slideMsg(msg, time = 3000) {
    if (time == 0) {
        $('#slideMsg').slideUp('fast');
        clearTimeout(slideTime);
    } else {
        $('#slideMsg div').html(msg);
        $('#slideMsg').slideDown('fast');
        slideTime = setTimeout(() => {
            $('#slideMsg').slideUp('fast');
        }, time);
    }
}

function dateBr(date, noTime = true) {
    let p1 = date.split(' ');
    let p2 = p1[0].split('-');
    if (noTime) return `${p2[2]}/${p2[1]}/${p2[0]}`;
    else return `${p2[2]}/${p2[1]}/${p2[0]} às ${p1[1]}`;
}

function getField(field, value, id = 0) {
    slideMsg(spinner, 10000);
    $.post(`${app.api}/field.php`, { field: field, value: value, id: id })
        .done((data) => {
            let jData = JSON.parse(data);
            if (jData.return == 'error') {
                slideMsg(jData.value);
                $(`#${field}`).addClass('invalid');
                $(`#${field}`).focus();
                $(`#${field}`).select();
            } else {
                $(`#${field}`).removeClass('invalid');
                slideMsg('', 0);
            }
        });
}

function today(plusDays) {
    var nowDate = new Date();
    var newDate = new Date();
    newDate.setDate(nowDate.getDate() + plusDays);
    return newDate.toISOString().split('T')[0];
}