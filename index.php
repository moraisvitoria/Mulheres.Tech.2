<?php

// Criando variáveis
$mesangem = "Estou com sede!";
$senha = "0123456789";

// Criando uma string
$titulo = 'Meu site - Contatos';

// CRiando um number
$idade_do_fesso = -17.99;

$idadeDoFesso = 17;
$CASA = 'Amarela';
$casa = 'azul';

$cnpj = '875908347095687340258';

// Criand uma boolean
$amarelo = true;

// Criando constante em PHP;
define('CASA', 'azul');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?></title>
</head>

<body>

    <?php echo "Olá terra!<br>\n";
    echo "\t<p>Olá planeta!</p>\n"; ?>

    <?php

    echo somar(10, 2) . "<br>";

    echo "Olá mundo!";

    echo '<p>Estou aqui!</p>';

    // echo `E você?`; Isso está errado.

    /*
Este comentário
tem várias linhas 
*/

    /* uma linha só */

    echo $mesangem;

    echo 18.99;

    echo $idade_do_fesso;

    ?>

</body>

</html>
<?php

echo 'Acabou!';

echo $idadeDoFesso;


echo '<br>' . $CASA . "<br>" . $casa . '<br>';
echo "<br>{$CASA}<br>{$casa}<br>"; // Interpolar


if ($amarelo):
    echo '<p>Amarelo</p>';
elseif (!$amarelo):
    echo '<p>Sem cor</p>';
    echo '';
endif;

$idade_do_fesso = "vinte e cinco anos";

echo '<br>' . $idade_do_fesso;

// define('casa', 'amarela'); → Constate já foi criada antes...

echo '<h1>' . CASA . '</h1>'; // Exibindo a constante CASA


// Função que soma dois valores e exibe o resultado no navegador:
function somar($val1, $val2)
{
    $soma = $val1 + $val2;
    return $soma;
}



?>