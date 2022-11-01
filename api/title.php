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

$url = post_clean('url', 'url');
$url = $_REQUEST['url'];
if ($url == '')
    _o(array(
        'return' => 'error',
        'id' => 23,
        'value' => 'Erro!<br>URL inválida...'
    ));

$html = file_get_contents_curl($url);
preg_match('/<title>(.+)<\/title>/', $html, $matches);
if (count($matches) > 0) {
    $title = $matches[1];
    _o(array(
        'return' => 'true',
        'id' => 27,
        'value' => array(
            'message' => 'Ok!<br>Título obtido...',
            'url' => $url,
            'title' => $title
        )
    ));
} else {
    _o(array(
        'return' => 'error',
        'id' => 28,
        'value' => 'Erro!<br>Não foi possível obter título...'
    ));
}
