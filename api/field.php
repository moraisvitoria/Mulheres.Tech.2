<?php
header('Content-Type: application/json; charset=utf-8');
require('../config/_config.php');

if (!isset($_COOKIE["{$site_name}_user"]))
    _o(array(
        'return' => 'error',
        'id' => 5,
        'value' => 'Erro!<br>Usuário não logado...'
    ));

$id = (isset($_POST['id'])) ? intval($_POST['id']) : 0;
if ($id == 0) $whereId = '';
else $whereId = "AND id != '{$id}'";

$field = (isset($_POST['field'])) ? trim(htmlentities($_POST['field'])) : '';
if ($field != 'url' && $field != 'short')
    _o(array(
        'return' => 'error',
        'id' => 17,
        'value' => 'Erro!<br>Campo não inválido...',
    ));

$value = (isset($_POST['value'])) ? trim(htmlentities($_POST['value'])) : '';
if ($field == '')
    _o(array(
        'return' => 'error',
        'id' => 16,
        'value' => 'Erro!<br>Valor do campo não informado...'
    ));

if (strlen($field) < 2 or strlen($field) > 64)
    _o(array(
        'return' => 'error',
        'id' => 26,
        'value' => 'Erro!<br>Valor do campo inválido...'
    ));

$sql = "SELECT id FROM redir WHERE {$field} = '{$value}' AND status != 'del' {$whereId};";
$res = $conn->query($sql);
if ($res->num_rows != 0)
    _o(array(
        'return' => 'error',
        'id' => 18,
        'value' => 'Erro!<br>Valor informado já está em uso...'
    ));
else
    _o(array(
        'return' => 'valid',
        'id' => 19,
        'value' => 'Ok!<br>Valor disponível para uso...'
    ));
