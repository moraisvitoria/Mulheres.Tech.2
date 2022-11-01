<?php
header('Content-Type: application/json; charset=utf-8');
require('../config/_config.php');

if (!isset($_COOKIE["{$site_name}_user"]))
    _o(array(
        'return' => 'error',
        'id' => 5,
        'value' => 'Erro!<br>Usuário não logado...'
    ));
else $user = json_decode($_COOKIE["{$site_name}_user"]);

$id = (isset($_POST['id'])) ? intval($_POST['id']) : 0;
if ($id == 0)
    _o(array(
        'return' => 'error',
        'id' => 10,
        'value' => 'Erro!<br>Shortlink não informado...'
    ));

$sql = "SELECT name, short FROM redir WHERE id = '${id}' AND status != 'del' AND user = '{$user->id}';";
$res = $conn->query($sql);
if ($res->num_rows != 1)
    _o(array(
        'return' => 'error',
        'id' => 11,
        'value' => 'Erro!<br>Shortlink não encontrado...'
    ));

$data = $res->fetch_assoc();
$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
$shortLink = "{$protocol}{$_SERVER['SERVER_NAME']}/{$data['short']}";

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

require_once('./../vendor/autoload.php');

$options = new QROptions(
    [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
    ]
);
$qrcode = (new QRCode($options))->render($shortLink);

_o(array(
    'return' => 'true',
    'id' => 14,
    'value' => array(
        'name' => $data['name'],
        'short' => $shortLink,
        'qrcode' => $qrcode
    )
));
