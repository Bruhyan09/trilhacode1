# Trilha Code

Portal educativo em PHP, HTML, CSS e JavaScript para praticar desenvolvimento web, estruturar projetos e aprender o fluxo de deploy no Render.

## Rodar localmente

É necessário PHP 8.1+ com extensão `mbstring` habilitada (os exemplos usam funções multibyte). Abra o terminal na raiz deste repositório e execute:

```bash
php -S 127.0.0.1:8000
```

Abra `http://127.0.0.1:8000`. O progresso, resultados e feedback ficam no `localStorage` do navegador. Para verificar a sintaxe dos arquivos PHP, use `find . -name '*.php' -print0 | xargs -0 -n1 php -l`.

## O que está incluído

As trilhas de PHP, CSS e JavaScript explicam utilidade, funcionamento e aplicações. Há módulos de VS Code, laboratório seguro de CSS/JavaScript, quizzes, busca, progresso e comentários locais. Os exemplos PHP são apresentados como código para leitura e cópia; o portal não executa PHP arbitrário enviado por um visitante. Projetos CRUD e Login estão disponíveis em `projetos/downloads/`.

## Publicar no Render

1. Envie este repositório ao GitHub, incluindo o `Dockerfile`.
2. No Render, crie um Web Service conectado ao repositório e selecione **Docker** como ambiente.
3. Mantenha `./Dockerfile` como caminho do arquivo e use `/` como health check path.
4. Inicie o deploy e confira os logs e a URL pública.

O container inicia PHP/Apache na porta informada por `PORT` (padrão `10000`) e escuta em `0.0.0.0`. O arquivo `render.yaml` fornece uma declaração inicial opcional para Render Blueprints. Veja o guia detalhado dentro do site em `/deploy/render.php` e confirme a configuração na documentação oficial, pois os painéis podem mudar.

## Limite intencional

O portal não exige banco de dados nem envia o progresso para um servidor. Dados locais não sincronizam entre navegadores/dispositivos. Os ZIPs de demonstração são projetos educacionais independentes e exigem revisão antes de qualquer uso real.
