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

$name = post_clean('name', 'string');
if (strlen($name) < 2 or strlen($name) > 64)
    _o(array(
        'return' => 'error',
        'id' => 20,
        'value' => 'Erro!<br>O nome deve ter entre 2 e 64 caracteres...'
    ));

$short = post_clean('short', 'string');
if (strlen($short) < 2 or strlen($short) > 64)
    _o(array(
        'return' => 'error',
        'id' => 21,
        'value' => 'Erro!<br>O shortlink deve ter entre 2 e 64 caracteres...'
    ));

$mode = strtolower(post_clean('mode', 'string'));
if ($mode != 'url' and $mode != '301')
    die(json_encode(array(
        'return' => 'error',
        'id' => 29,
        'value' => 'Erro!<br>Modo inválido...'
    )));

$status = strtolower(post_clean('status', 'string'));
if ($status != 'on' and $status != 'off')
    _o(array(
        'return' => 'error',
        'id' => 22,
        'value' => 'Erro!<br>Status inválido...'
    ));

$url = strtolower(post_clean('url', 'url'));
if ($url == '')
    _o(array(
        'return' => 'error',
        'id' => 23,
        'value' => 'Erro!<br>URL inválida...'
    ));

$expires = post_clean('expires', 'date');
if ($expires == '')
    _o(array(
        'return' => 'error',
        'id' => 24,
        'value' => 'Erro!<br>Data de expiração inválida...'
    ));

$sql = "UPDATE redir SET name = '{$name}', short = '{$short}', url = '{$url}', expires = '${expires}', status = '${status}', mode = '${mode}' WHERE id = '${id}' AND status != 'del' AND user = '{$user->id}';";
$res = $conn->query($sql);

_o(array(
    'return' => 'true',
    'id' => 25,
    'value' => 'Ok!<br>Shortlink atualizado...'
));
