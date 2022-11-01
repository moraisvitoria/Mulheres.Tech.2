changeTitle('Shortlinks');
if (getCookie(app.cookie + '_user') == '') loadPage('login');

var order;
var options = { date: 'Criação', short: 'Shortlink', url: 'URL original', name: 'Nome', expires: 'Expiração', counter: 'Cliques', status: 'Status' }

var ckOptions = getCookie(app.cookie + '_options');
if (ckOptions == '') order = { fld: 'date', dir: 'DESC' }
else order = JSON.parse(ckOptions);

var select = '';
for (const option in options) {
    if (option == order.fld) select += `<option value="${option}" selected>${options[option]}</option>`;
    else select += `<option value="${option}">${options[option]}</option>`;
}
$('#field').html(select);
$(`#${order.dir}`).css('color', 'orangered');

setCookie(app.cookie + '_short', '', -1);

$('#field').change(changeField);
$('#direction span').click(changeDir);

$.post(`${app.api}/index.php`, order)
    .done((data) => {
        if (!data) $('#content').html(`<div class="center red"><h4 class="center red">Erro!</h4>Falha de comunicação com a API...</div>`);
        else {
            jData = JSON.parse(data);
            if (jData.return == 'false') {
                $('#content').html(`<div class="center red"><h4 class="center red">Oooops!</h4>Nenhum <em>shortlink</em> cadastrado...</div>`);
            } else if (jData.return == 'error') {
                slideMsg(jData.value);
            } else if (jData.return == 'true') {
                let html = '<div class="list">';
                console.log(JSON.stringify(jData));
                oData = jData.value
                for (i = 0; i < oData.length; i++) {
                    let o = oData[i];
                    if (o.mode == 'url') {
                        o.realMode = '<strong title="Redirecionamento usando URL.">URL</strong>';
                    } else {
                        o.realMode = '<strong title="Redirecionamento usando HTTP 301.">301</strong>';
                    }
                    if (o.status == 'on') {
                        o.realStatus = '<strong class="green">Ativo</strong>';
                        o.statusIcon = '<i class="fa-regular fa-square-check fa-fw"></i>';
                    } else {
                        o.realStatus = '<strong class="red">Inativo</strong>';
                        o.statusIcon = '<i class="fa-regular fa-square fa-fw"></i>';
                    }
                    html += `
<div class="list-box">
    <h3 class="list-title">${o.name} (${o.counter})</h3>
    <div class="short"><a href="${app.url}/${o.short}" target="_blank">${app.url}/<strong class="orange">${o.short}</strong></a></div>
    <div class="url"><i class="fa-solid fa-link fa-fw"></i> <a href="${o.url}" target="_blank" title="${o.url}">${o.url}</a></div>
    <div class="tools">
        <span data-action="copy" data-short="${app.url}/${o.short}" class="short-tools" title="Copiar link"><i class="fa-regular fa-copy fa-fw"></i></span>
        <span data-action="edit" data-id="${o.id}" class="short-tools" title="Editar link"><i class="fa-solid fa-pen-to-square fa-fw"></i></span>
        <span data-action="del" data-id="${o.id}" class="short-tools" title="Apagar link"><i class="fa-solid fa-trash-can fa-fw"></i></span>
        <span data-action="qrcode" data-id="${o.id}" class="short-tools" title="Gerar QRCode"><i class="fa-solid fa-qrcode fa-fw"></i></span>
        <span data-action="status" data-id="${o.id}" class="short-tools" title="Alterar status">${o.statusIcon}</span>
    </div>
    <div class="expires">${o.realMode} ${o.realStatus} <span>Expira em ${dateBr(o.expires)}.</span></div>
</div>
                    `;
                }
                html += '</div>'
                $('#content').html(html);
                $('.short-tools').click(runTool);
            }
        }
    });

function runTool() {
    let action = $(this).attr('data-action');
    let id = $(this).attr('data-id');
    let short = $(this).attr('data-short');
    switch (action) {

        case 'copy':
            navigator.clipboard.writeText(short);
            slideMsg('Link copiado...');
            break;

        case 'edit':
            setCookie(app.cookie + '_shortId', id);
            loadPage('edit');
            break;

        case 'del':
            msg = `
<h3>Oooops!</h3>Tem certeza que deseja apagar o "shortlink"? Essa ação é irreversível.
<p class="confirm-buttons">
    <button class="confirm" data-id="${id}">Sim</button>
    <button class="reset">Não</button>
</p>        
        `;
            slideMsg(msg, 15000);
            $('.confirm-buttons button').click(runBtnAction);
            break;

        case 'qrcode':
            setCookie(app.cookie + '_shortId', id);
            loadPage('qrcode');
            break;

        case 'status':
            $.post(`${app.api}/status.php`, { id: id })
                .done((data) => {
                    let jData = JSON.parse(data);
                    if (jData.return == 'error') slideMsg(jData.value);
                    else {
                        slideMsg(jData.value);
                        loadPage('home');
                    }
                });
            break;
    }
}

function runBtnAction() {
    slideMsg(spinner, 10000);
    if ($(this).attr('class') == 'confirm') {
        let id = $(this).attr('data-id');
        $.post(`${app.api}/del.php`, { id: id })
            .done((data) => {
                let jData = JSON.parse(data);
                if (jData.return == 'error') slideMsg(jData.value);
                else {
                    slideMsg(jData.value);
                    loadPage('home');
                }
            });
    }
}

function changeField() {
    let field = $(this).val();
    setCookie(app.cookie + '_options', JSON.stringify({ 'fld': field, 'dir': order.dir }));
    loadPage('home');
}

function changeDir() {
    let dirId = $(this).attr('id');
    setCookie(app.cookie + '_options', JSON.stringify({ 'fld': order.fld, 'dir': dirId }));
    loadPage('home');
}