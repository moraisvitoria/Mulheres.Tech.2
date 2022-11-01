<?php
header('Content-Type: application/json; charset=utf-8');
require('../config/_config.php');

$email = post_clean('email', 'email');
if ($email == '')
    _o(array(
        'return' => 'error',
        'id' => 1,
        'value' => 'Erro!<br>E-mail inválido...'
    ));

$paswd = post_clean('password', 'string');
if ($paswd == '')
    _o(array(
        'return' => 'error',
        'id' => 2,
        'value' => 'Erro!<br>Senha inválida...'
    ));

$logged = false;
if (trim(strtolower($_POST['logged'])) == 'true') $logged = true;

$sql = "SELECT * FROM users WHERE email = '{$email}' AND password = SHA1('{$paswd}') AND status = 'on';";
$res = $conn->query($sql);

if ($res->num_rows != 1)
    _o(array(
        'return' => 'error',
        'id' => 3,
        'value' => 'Erro!<br>Cadastro não encontrado...'
    ));

$ck = $res->fetch_assoc();
unset($ck['password']);

if ($logged) $ck_validate = time() + (86400 * 90);
else  $ck_validate = 0;

$conn->query("UPDATE users SET lastlogin = NOW() WHERE id = '';");

setcookie("{$site_name}_user", json_encode($ck), $ck_validate, '/');

_o(array(
    'return' => 'true',
    'id' => 4,
    'value' => 'Ok!<br>Logado com sucesso...'
));
