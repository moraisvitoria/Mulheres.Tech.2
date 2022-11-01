changeTitle('QRCode');
if (getCookie(app.cookie + '_user') == '') loadPage('login');

var id = parseInt(getCookie(app.cookie + '_shortId'));
if (id == 0 || id == NaN) slideMsg('Erro!<br>Selecione um shortlink...');
else {
    slideMsg(spinner, 10000);
    $.post(`${app.api}/qrcode.php`, { id: id })
        .done((data) => {
            jData = JSON.parse(data);
            if (jData.return == 'error') {
                slideMsg(jData.value);
                switch (jData.id) {
                    case 5: loadPage('login'); break;
                    case 10: loadPage('home'); break;
                    case 11: loadPage('home'); break;
                }
            } else {
                oData = `
<div class="qrcode">
    <h3>${jData.value.name}</h3>
    <a href="${jData.value.short}" target="_blank"><img src="${jData.value.qrcode}" alt="${jData.value.name}"></a>
    <small><a href="${jData.value.short}" target="_blank">${jData.value.short}</a></small>
    <p><button id="btnReturn">&larr; Voltar</button></p>
</div>
                `;
                $('#content').html(oData);
                $('#btnReturn').click(() => {
                    loadPage('home');
                });
                slideMsg('', 0);
            }
        });
}