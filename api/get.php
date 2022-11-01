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

$sql = "SELECT * FROM redir WHERE id = '{$id}' AND status != 'del' AND user = '{$user->id}';";
$res = $conn->query($sql);

if ($res->num_rows != 1)
    _o(array(
        'return' => 'error',
        'id' => 11,
        'value' => 'Erro!<br>Shortlink não encontrado...'
    ));

$sl = $res->fetch_assoc();
_o(array(
    'return' => 'success',
    'id' => 15,
    'value' => $sl
));
