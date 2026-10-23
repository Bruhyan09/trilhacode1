# Projeto de estudo: CRUD de tarefas

CRUD significa criar, ler, atualizar e excluir. Este projeto didático usa PHP 8.1+, formulários POST, validação simples, token CSRF, escape de saída e JSON em arquivo.

## Executar

Na pasta extraída, rode `php -S 127.0.0.1:8000 -t public` e abra `http://127.0.0.1:8000`. PHP precisa ter `mbstring` habilitada. Os dados são salvos em `var/tasks.json`, fora de `public/`.

## Explorar

`public/index.php` recebe as ações; `src/bootstrap.php` concentra validação CSRF, helpers e persistência; `public/style.css` cuida da interface. Crie algumas tarefas, conclua e remova para seguir o fluxo.

Este exercício usa JSON para reduzir configuração. `LOCK_EX` reduz risco de escrita simultânea durante uma operação simples, mas não substitui uma base de dados transacional para concorrência, backup, consultas e autenticação. Faça revisão antes de expor qualquer aplicação à internet.
