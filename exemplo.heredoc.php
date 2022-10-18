<?php 

$title = 'Minha página';
$content = 'Isso é um heredoc';

$minha_pagina = <<<HTML

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
</head>
<body>

<h1>{$content}</h1>HTML

<script>console.log('Olá mundo!');</script>
    
</body>
</html>

HTML; // lixo

$style = <<<CSS

body { background: red; }

CSS;

$sql = <<<SQL

SELECT * FROM user WHERE user_name = 'joca' AND user_pass = '123' AND user_status = 'active';

SQL;

echo $minha_pagina;
