# Projeto de estudo: cadastro e login

Exercício educacional em PHP 8.1+ com `password_hash`, `password_verify`, sessão, regeneração do ID após entrada e token CSRF. Cadastros ficam em JSON fora da raiz pública (`var/users.json`).

## Executar

Na pasta extraída, rode `php -S 127.0.0.1:8000 -t public` e acesse `http://127.0.0.1:8000`. PHP precisa ter `mbstring` habilitada. Cadastre um usuário de teste usando um e-mail inventado e uma senha exclusiva para o exercício.

## Estrutura

`public/index.php` trata os formulários; `src/bootstrap.php` inicia sessão e agrupa helpers/CSRF/persistência; `var/` é armazenamento privado fora da raiz web.

## Aviso

Não use senhas reais. A persistência JSON é apenas para estudo local; o pacote não inclui rate limiting, fluxo de recuperação, e-mail verificado, política de retenção, monitoramento, banco concorrente nem configuração completa de produção. Faça revisão independente antes de publicar. Use HTTPS e revise cookies, armazenamento, abuso e privacidade.
