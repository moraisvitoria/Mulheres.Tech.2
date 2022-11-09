<?php

// Define o título desta página:
$page_title = "Página modelo";

// Define as variáveis do aplicativo:
$email = 'joca@silva.com';
$password = 'Senha123';

// Se o formulário foi enviado...


//  Formulário de login:
$form_login = <<<HTML

<form method="post" action="/?login" id="formLogin">
    <input type="text" name="send" value="true">

    <p>Logue-se para ter acesso aos conteúdos restritos:</p>

    <p>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" value="{$email}" required>
    </p>

    <p>
        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" autocomplete="off" value="{$password}" required pattern="{$rgpass}">
    </p>

    <p class="logged">
        <input type="checkbox" name="logged" id="logged" value="on">
        <label for="logged">Mantenha-me logado.</label>
    </p>

    <p>
        <button type="submit">Entrar</button>
    </p>

    <hr>

    <p class="loginlinks">
        <a href="/?signup">Cadastre-se</a>
        <a href="/?sendpass">Esqueci a senha</a>
    </p>

</form>

HTML;

// Definir o conteúdo desta página:
$page_content = <<<HTML

<article>
    <h2>Login / Entrar</h2>
    {$form_login}
</article>

<aside>
    <h3>Complemento</h3>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
</aside>

HTML;
