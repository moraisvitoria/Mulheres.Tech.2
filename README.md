
# PHP_Shortner
*Versão 0.5-beta*

Um redirecionador / encurtador de URL vanilla, **experimental**, com PHP e MySQL.

## Alguns recursos

- Front-end administrativo SPA usando HTML5, CSS3, JavaScript;
- Framework "[jQuery](https://github.com/jquery)" para facilitar o acesso ao DOM;
- Back-end acessado via [API REST](https://pt.wikipedia.org/wiki/REST) ([JSON](https://pt.wikipedia.org/wiki/JSON)) com PHP8 e MySQL;
- Multiusuário. Cada usuário gerencia seus próprios shortlinks;
- Gerador de QRcode para os shortlinks usando [chillerlan/php-qrcode](https://github.com/chillerlan/php-qrcode).

## O que ainda falta?
Faça seu "Fork" e colabore para melhorar este projeto. Abaixo estão alguns requisitos que ainda não foram suportados / implementados:

 - Testes e mais testes em busca dos *bugs* e suas correções;
 - Gerenciamento dos usuários (cadastro, editar perfil, gerir senha, gerir imagem, etc.) ou, talvez, integração com redes sociais usando [OAuth](https://pt.wikipedia.org/wiki/OAuth);
 - ~~Ao criar um novo shortlink, detectar automaticamente o nome do link original (Talvez, ler o valor a tag `title`?);~~
 - Configurar [PWA](https://pt.wikipedia.org/wiki/Progressive_web_app);
 - Converter API PHP para [POO](https://pt.wikipedia.org/wiki/Programa%C3%A7%C3%A3o_orientada_a_objetos);
- Comentar os códigos para torná-los mais didáticos;
- Melhorar segurança (Talvez, usando [reCAPTCHA](https://pt.wikipedia.org/wiki/ReCAPTCHA)?);
- Otimizar muito o JavaScript;
- ...

## Como obter, instalar e testar
Esta é a forma mais básica de obter, testar e colaborar com o desenvolvimentod o aplicativo. Se você é especialista, faça do seu jeito! 😉

 - Baixe e instale a versão mais recente do [XAMPP](https://www.apachefriends.org/download.html) para seu sistema;
 - Renomeie a pasta "`htdocs`" que está dentro da pasta do XAMPP para outra coisa ou, se tiver muita coragem, apague ela;
 - Faça "fork" do [repositório](https://github.com/Luferat/PHP_Shortner) se for colaborar com o desenvolvimento do aplicativo ou quiser fazer o seu com base nele;
 - Baixe ou "clone" o aplicativo para uma nova pasta "`htdocs`", dentro da pasta do XAMPP. No Windows, deve ser algo como "`C:\xampp\htdocs`"; já no Linux, temos algo como "`/opt/xampp/htdocs`";
 - "Rode" o SQL de "`redir.sql`" que está dentro da pasta "`/config`" no seu MySQL, usando linha de comando ou pelo [PHPMyAdmin](https://www.phpmyadmin.net/) que já vem com o XAMPP;
 - Rode o Apache e o MySQL pelo painel de controles do XAMPP;
 - Acesse "http://localhost/admin" para entrar na área administrativa. Login e senha de teste estão em "`redir.sql`" que está dentro da pasta "`/config`";
 - Pronto! Se vira com o resto ou cria uma nova "[issue](https://github.com/Luferat/PHP_Shortner/issues)"...
