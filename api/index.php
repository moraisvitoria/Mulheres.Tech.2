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

$fields = array('id', 'date', 'name', 'short', 'url', 'user', 'expires', 'counter', 'status');
$directions = array('ASC', 'DESC');

$fld = isset($_POST['fld']) ? trim(htmlentities(strtolower($_POST['fld']))) : 'date';
if (!in_array($fld, $fields))
    _o(array(
        'return' => 'error',
        'id' => 6,
        'value' => 'Erro!<br>Campo informado inválido...'
    ));

$dir = isset($_POST['dir']) ? trim(htmlentities(strtoupper($_POST['dir']))) : 'DESC';
if (!in_array($dir, $directions))
    _o(array(
        'return' => 'error',
        'id' => 7,
        'value' => 'Erro!<br>Parâmetro informado inválido...'
    ));

$sql = "SELECT * FROM redir WHERE status != 'del' AND user = '{$user->id}' ORDER BY {$fld} {$dir};";
$res = $conn->query($sql);

$total = $res->num_rows;
if ($total == 0)
    _o(array(
        'return' => 'false',
        'id' => 8,
        'value' => 'Oooops!<br>Nenhum shortlink cadastrado...'
    ));

$adata = array();
while ($out = $res->fetch_assoc()) array_push($adata, $out);
_o(array(
    'return' => 'true',
    'id' => 9,
    'count' => $total,
    'value' => $adata
));
