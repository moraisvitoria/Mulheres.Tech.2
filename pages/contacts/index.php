<?php

// Se o formulário foi enviado:
if (isset($_POST['send'])) :

    // Obtém o 'name' do formulário:
    $name = htmlspecialchars(trim($_POST['name']));
    

endif;

// Define o título desta página:
$page_title = "Faça contato";

// Definir o conteúdo desta página:
$page_content = <<<HTML

<!-- Conteúdo principal -->
<article>

  <h2>Faça contato</h2>
  <p>Preencha todos os campos abaixo para enviar um contato para a equipe do <strong>Mulheres.Tech</strong>.</p>

  <!--
    Formulário de contatos
    Referências: https://www.w3schools.com/html/html_forms.asp
  -->
  <form action="?contacts" method="post" name="contacts" id="contacts">
    <input type="hidden" name="send" value="true">

    <p>
      <label for="name">Nome:</label>
      <input type="text" name="name" id="name" required minlength="3" placeholder="Seu nome completo" value="Joca da Silva">
    </p>

    <p>
      <label for="email">E-mail:</label>
      <input type="email" name="email" id="email" required placeholder="Seu e-mail principal" value="joca@silva.com">
    </p>

    <p>
      <label for="subject">Assunto:</label>
      <input type="text" name="subject" id="subject" required minlength="5" placeholder="Assunto do contato" value="Teste de contato">
    </p>

    <p>
      <label for="message">Mensagem:</label>
      <textarea name="message" id="message" required minlength="5" placeholder="Sua mensagem">Mais um contato do joca</textarea>
    </p>

    <p>
      <button type="submit">Enviar</button>
    </p>

  </form>&nbsp;

</article>

<!-- Conteúdo complementar / barra lateral -->
<aside>

  <h3>+ Contatos</h3>

  <p>Você também pode nos encontrar e falar conosco através de outros canais:</p>

  <nav class="social">
    <a href="https://facebook.com/Mulheres.Tech" target="_blank" title="Facebook">
      <i class="fa-brands fa-facebook fa-fw fa-3x"></i>
    </a>
    <a href="https://youtube.com/Mulheres.Tech" target="_blank" title="Youtube">
      <i class="fa-brands fa-youtube fa-fw fa-3x"></i>
    </a>
    <a href="https://github.com/Mulheres.Tech" target="_blank" title="GitHub">
      <i class="fa-brands fa-github fa-fw fa-3x"></i>
    </a>
    <a href="mailto:mulhetes@tech.com.br" target="_blank" title="E-mail">
      <i class="fa-solid fa-envelope fa-fw fa-3x"></i>
    </a>
    <a href="https://wa.me/5521987654321" target="_blank" title="WhatsApp">
      <i class="fa-brands fa-whatsapp fa-fw fa-3x"></i>
    </a>
    <a href="tel://5521987654321" target="_blank" title="Telefone">
      <i class="fa-solid fa-phone fa-fw fa-3x"></i>
    </a>
  </nav>

  <h3>+ Sobre</h3>
  <nav class="about">
    <a href="about">
      <i class="fa-solid fa-circle-info fa-fw"></i>
      <span>Sobre o site</span>
    </a>
    <a href="team">
      <i class="fa-solid fa-user-tie fa-fw"></i>
      <span>Quem somos</span>
    </a>
    <a href="policies">
      <i class="fa-solid fa-user-lock fa-fw"></i>
      <span>Sua privacidade</span>
    </a>
  </nav>

</aside>

HTML;
