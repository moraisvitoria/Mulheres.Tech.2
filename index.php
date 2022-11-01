<?php
require($_SERVER['DOCUMENT_ROOT'] . '/config/_config.php');
$url = htmlentities(trim($_SERVER['QUERY_STRING']));
if ($url == '') require('404.html');
$sql = "SELECT id, url, mode, counter FROM redir WHERE short = '{$url}' AND status = 'on' AND expires >= NOW()";
$res = $conn->query($sql);
if ($res->num_rows != 1) :
    require('404.html');
else :
    $data = $res->fetch_assoc();
    $counter = $data['counter'] + 1;
    $sql = "UPDATE redir SET counter = '{$counter}' WHERE id = '{$data['id']}'";
    $conn->query($sql);
    if ($data['mode'] == '301') header("HTTP/1.1 301 Moved Permanently");
    header("Location: {$data['url']}");
endif;
