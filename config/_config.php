<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

$site_name = 'Luferat_Redir';

/**
 * Define a Regex de validação de senha:
 * 
 * IMPORTANTE!
 * Conforme nossas "políticas de segurança", a senha do usuário deve seguir as
 * seguintes regras:
 *
 *     • Entre 7 e 25 caracteres;
 *     • Pelo menos uma letra minúscula;
 *     • Pelo menos uma letra maiúscula;
 *     • Pelo menos um número.
 *
 * A REGEX abaixo especifica essas regras:
 *
 *     • HTML5 → pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{7,25}$"
 *     • JavaScript → \^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{7,25}$\
 *     • PHP → "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{7,25}$/"
 **/
$rgpass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{7,25}$/";

/********************************
 * Conexão com o banco de dados *
 ********************************/

// Lê arquivo "ini" e converte em um array:
$db = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/_config.ini', true);

// Itera elementos de $db:
// Referências: https://www.php.net/manual/pt_BR/control-structures.foreach.php
foreach ($db as $server => $values) :

    // Se estamos no servidor correto:
    if ($server == $_SERVER['SERVER_NAME']) :

        // Conecta no banco de dados com as credenciais deste servidor:
        $conn = new mysqli($values['hostname'], $values['username'], $values['password'], $values['database']);

        // Trata possíveis exceções:
        if ($conn->connect_error) die("Falha de conexão com o banco e dados: " . $conn->connect_error);

    endif;
endforeach;

// Seta transações com MySQL/MariaDB para UTF-8:
$conn->query("SET NAMES 'utf8'");
$conn->query('SET character_set_connection=utf8');
$conn->query('SET character_set_client=utf8');
$conn->query('SET character_set_results=utf8');

// Seta dias da semana e meses do MySQL/MariaDB para "português do Brasil":
$conn->query('SET GLOBAL lc_time_names = pt_BR');
$conn->query('SET lc_time_names = pt_BR');

// Se o cookie do usuário existe (usuário logado)...
if (isset($_COOKIE["{$site_name}_user"])) :

    // Gera array com dados do usuário, convertendo JSON em array ($user[]):
    $user = json_decode($_COOKIE["{$site_name}_user"], true);

// Se o cookie não existe (ninguém está logado)...
else :

    // Dados do usuário não exitem:
    $user = false;

endif;

// Mensagens:
$popup = array(
    '', // 0
    'Erro!<br>E-mail inválido...', // 1
    'Erro!<br>Senha inválida...', // 2
    'Erro!<br>Cadastro não encontrado...', // 3
    'Ok!<br>Logado com sucesso...', // 4

    'Erro!<br>Usuário não logado...', // 5
    'Erro!<br>Campo informado inválido...',
    'Erro!<br>Parâmetro informado inválido...',
    'Oooops!<br>Nenhum shortlink cadastrado...',
    'Ok!<br>Shortlinks encontrados...',

    'Erro!<br>Shortlink não informado...', // 10
    'Erro!<br>Shortlink não encontrado...',
    'Ok!<br>Shortlink apagado...',
    'Erro!<br>Shortlink não informado...',
    'Ok!<br>Status atualizado...',

    'Ok!<br>Shortlink encontrado...', // 15
    'Erro!<br>Valor do campo não informado...',
    'Erro!<br>Campo não inválido...',
    'Erro!<br>Valor informado já está em uso...',
    'Ok!<br>Valor disponível para uso...',

    'Erro!<br>O nome deve ter entre 2 e 64 caracteres...', // 20
    'Erro!<br>O shortlink deve ter entre 2 e 64 caracteres...',
    'Erro!<br>Status inválido...',
    'Erro!<br>URL inválida...',
    'Erro!<br>Data de expiração inválida...',

    'Ok!<br>Shortlink atualizado...', // 25
    'Erro!<br>Valor do campo inválido...',
    'Ok!<br>Título obtido...',
    'Erro!<br>Não foi possível obter título...',
    'Erro!<br>Modo inválido...'

);

/************************
 * Funções de uso geral *
 ***********************/

// Sanitiza campos de formulários usando method="POST":
// Outros filtros podem ser implementados nesta função.
function post_clean($post_field, $type = 'string')
{

    // Escolhe o tipo de filtro
    switch ($type):
        case 'string':

            // Sanitiza strings
            $post_value = htmlspecialchars($_POST[$post_field]);
            break;

        case 'email':

            // Sanitiza endereços de e-mail
            $post_value = filter_input(INPUT_POST, $post_field, FILTER_SANITIZE_EMAIL);
            break;

        case 'url':

            // Sanitiza URL
            $post_value = filter_input(INPUT_POST, $post_field, FILTER_SANITIZE_URL);
            break;

        case 'date':

            $post_value = preg_replace("([^0-9/] | [^0-9-])", "", $_POST[$post_field]);
            break;

    endswitch;

    // Remove excesso de espaços
    $post_value = trim($post_value);

    // Remove aspas perigosas
    $post_value = stripslashes($post_value);

    // Retorna valor do campo sanitizado
    return $post_value;
}

/**
 * Facilita o debug (Isso não é usado em produção):
 * 
 * Você pode usar tanto "print_r()" quanto "var_dump()". Ambas fazem a mesma 
 * coisa só que tem uma formatação diferente, sendo, portanto, questão de 
 * gosto.
 * 
 *    • A saída de "var_dump()" é mais detalhada, porém, "mais poluída";
 *    • A saída de "print_r()" é mais simples e menos detalhada.
 * 
 * Para escolher, mantenha descomentada apenas a função que quer usar e 
 * comente a outra.
 **/
function debug($element, $pre = true, $stop = true)
{
    if ($pre) echo '<pre>';
    print_r($element);
    // var_dump($element);
    if ($pre) echo '</pre>';
    if ($stop) exit;
}

function file_get_contents_curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function _o($out_array)
{
    die(json_encode($out_array));
}
