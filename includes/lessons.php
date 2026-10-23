<?php
/** Conteúdo didático editorial; os trechos em HTML são controlados pelo projeto. */
$LESSONS = [
  'home' => ['title'=>'Aprender construindo','eyebrow'=>'INÍCIO'],
  'php-index' => [
    'title'=>'PHP: regras que rodam no servidor','eyebrow'=>'TRILHA 01 · BACKEND','crumb'=>'PHP','lead'=>'PHP recebe requisições, aplica regras e devolve HTML ou dados. Entenda o papel do backend e comece com práticas que não viram retrabalho.','time'=>'8 min de leitura','badge'=>'PHP','next'=>['php-utilidade','php-como-funciona','php-onde-usar'],
    'sections'=>[
      ['title'=>'O trabalho do PHP em uma aplicação','body'=> <<<'HTML'
<p>PHP é uma linguagem de programação executada principalmente no servidor. O navegador pede uma página; o servidor executa o código, consulta ou transforma dados e envia uma resposta. O usuário recebe HTML, JSON, CSS ou outro recurso, mas não o código PHP que produziu a resposta.</p><p>Esse modelo é útil para manter no servidor as regras do negócio, a validação e o acesso a dados. Para uma interface dinâmica, PHP pode montar HTML no servidor e JavaScript pode cuidar de interações locais no navegador. As tecnologias se complementam: cada uma atua onde resolve melhor o problema.</p>
HTML],
      ['title'=>'Uma requisição, da entrada à resposta','body'=> <<<'HTML'
<ol><li>O navegador envia uma requisição HTTP para uma rota.</li><li>O servidor encaminha o caminho a um arquivo ou aplicação PHP.</li><li>O PHP valida a entrada, decide o que fazer e prepara a resposta.</li><li>O servidor envia o status HTTP e o corpo da resposta.</li><li>O navegador renderiza a página; o JavaScript pode adicionar comportamento.</li></ol><p>Em aplicação real, separe apresentação, regras e persistência. Valide cada entrada, use prepared statements ao falar com banco, escape valores ao inseri-los em HTML e devolva status HTTP coerentes.</p>
HTML],
      ['title'=>'Um exemplo pequeno, com saída segura','body'=> <<<'HTML'
<p>Para inserir texto recebido de uma pessoa dentro de HTML, codifique caracteres especiais. Isso evita que uma entrada seja interpretada como marcação ou script.</p>
HTML],
      ['title'=>'Teste seu entendimento','body'=> <<<'HTML'
<p>Se a regra de negócio está em PHP, o que chega ao navegador? A resposta normalmente é o documento montado — não a implementação PHP.</p>
HTML],
    ],
    'code'=>['language'=>'PHP','class'=>'php','filename'=>'saudacao.php','source'=> <<<'CODE'
<?php
$nome = trim($_GET['nome'] ?? 'estudante');
$nomeSeguro = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
?>
<h1>Olá, <?= $nomeSeguro ?>!</h1>
CODE
      ,'note'=>'PHP é processado no servidor. O portal mostra e explica o código, mas não executa código arbitrário no navegador.'],
    'quiz'=>[
      ['question'=>'Onde o código PHP normalmente é executado?','options'=>['No servidor web, antes da resposta chegar ao navegador.','No CSS do navegador.','Dentro do arquivo de imagem.'],'answer'=>0,'explanation'=>'O servidor executa o PHP e envia ao cliente a resposta produzida.'],
      ['question'=>'O que `htmlspecialchars` ajuda a fazer neste exemplo?','options'=>['Criptografar a conexão de rede.','Escapar caracteres especiais antes de colocá-los em HTML.','Instalar PHP no computador.'],'answer'=>1,'explanation'=>'A função converte caracteres que poderiam ser interpretados como marcação HTML.'],
      ['question'=>'Qual camada costuma cuidar do layout visual?','options'=>['CSS.','PHP sempre.','A URL do domínio.'],'answer'=>0,'explanation'=>'CSS descreve aparência e layout; PHP pode entregar o HTML que receberá esses estilos.'],
    ],
  ],
  'php-utilidade' => [
    'title'=>'Para que usar PHP','eyebrow'=>'TRILHA 01 · PHP','crumb'=>'PHP / Utilidade','lead'=>'Use PHP quando a aplicação precisa receber uma requisição, aplicar regras no servidor e produzir uma resposta sob medida.','time'=>'6 min de leitura','next'=>['php-como-funciona','php-onde-usar'],
    'sections'=>[
      ['title'=>'A utilidade principal','body'=> <<<'HTML'
<p>PHP conecta a requisição do usuário às regras e aos dados da aplicação. Ele pode validar um formulário, decidir se alguém tem permissão, consultar dados, formatar uma resposta HTML e expor um endpoint JSON. Esse código fica fora do navegador, o que é importante para regras e segredos que não devem ser publicados.</p><p>Não use PHP só para imprimir texto estático. Se a página não precisa de lógica no servidor, HTML e CSS podem bastar. Escolha a tecnologia de acordo com a responsabilidade e mantenha o processamento no lado adequado.</p>
HTML],
      ['title'=>'Quando faz sentido no projeto','body'=> <<<'HTML'
<ul><li><strong>Formulários:</strong> validar campos no servidor, normalizar dados e confirmar recebimento.</li><li><strong>Conteúdo dinâmico:</strong> exibir listas, artigos ou páginas com informações atualizadas.</li><li><strong>Integrações:</strong> comunicar com serviços de pagamento, busca ou sistemas internos sem expor credenciais.</li><li><strong>APIs:</strong> receber e responder JSON para interfaces web e aplicativos.</li><li><strong>Autorização:</strong> proteger operações que dependem de uma sessão ou permissão.</li></ul><p>Validação no navegador melhora a experiência, mas nunca substitui a validação no servidor: a requisição pode ser construída fora da interface.</p>
HTML],
      ['title'=>'Critério profissional','body'=> <<<'HTML'
<p>Pergunte: a decisão precisa ser confiável para todos os clientes? Se sim, ela pertence ao servidor. Em seguida, defina entradas, respostas, códigos HTTP, tratamento de erro e forma de teste. Para conteúdo e formulários, evite misturar regra complexa diretamente no HTML.</p><p>Veja o fluxo completo em <a href="/php/como-funciona.php">Como o PHP funciona</a> e as aplicações em <a href="/php/onde-usar.php">Casos de mercado</a>.</p>
HTML],
    ],
    'code'=>['language'=>'PHP','class'=>'php','filename'=>'resposta.php','source'=> <<<'CODE'
<?php
$quantidade = filter_input(INPUT_GET, 'q', FILTER_VALIDATE_INT);
if ($quantidade === false || $quantidade === null || $quantidade < 1) {
    http_response_code(400);
    exit('Informe uma quantidade válida.');
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['itens' => $quantidade]);
CODE
    ,'note'=>'Valide entradas mesmo quando a interface também faz validação; a decisão confiável é a do servidor.'],
  ],
  'php-como-funciona' => [
    'title'=>'O ciclo de uma página PHP','eyebrow'=>'TRILHA 01 · PHP','crumb'=>'PHP / Como funciona','lead'=>'Veja como uma requisição se transforma em uma resposta e onde entram validação, sessões, arquivos e banco de dados.','time'=>'9 min de leitura','next'=>['php-onde-usar','vscode-servidor'],
    'sections'=>[
      ['title'=>'Ponto de entrada e métodos HTTP','body'=> <<<'HTML'
<p>Uma URL chega a um servidor web, que decide como localizar o recurso. Um arquivo `.php` pode ler `$_GET` para parâmetros da URL, `$_POST` para formulários, `$_SERVER` para metadados da requisição e `$_SESSION` para estado associado a uma sessão. Trate todos esses valores como entrada externa, inclusive cookies e cabeçalhos.</p><p>GET costuma consultar recursos; POST costuma enviar uma alteração. Isso é uma convenção de HTTP, não uma barreira de segurança. Para alterações, valide permissões e considere proteção contra CSRF.</p>
HTML],
      ['title'=>'Separação e segurança de saída','body'=> <<<'HTML'
<p>Separe o controle da requisição das funções de domínio e da apresentação. Helpers e `include` reduzem repetição, mas arquivos incluídos ainda executam no mesmo processo; não inclua caminhos arbitrários vindos do usuário. Use `require_once` para dependências fundamentais.</p><ul><li>Valide o tipo, tamanho e faixa esperada de cada campo.</li><li>Use consultas preparadas para banco de dados, nunca concatene entrada em SQL.</li><li>Escape conteúdo ao exibi-lo em HTML e configure cookies de sessão com segurança.</li><li>Registre erros no servidor; não mostre stack trace ou segredos ao visitante.</li></ul>
HTML],
      ['title'=>'Inspecione o request e a resposta','body'=> <<<'HTML'
<p>Ao depurar, confira a aba Network do navegador: método, URL, status e corpo da resposta. Nos logs do servidor, investigue erros sem imprimir credenciais. Um status `400` aponta entrada inválida, `401/403` falta de autenticação ou permissão, `404` recurso não encontrado e `500` falha não esperada no servidor.</p>
HTML],
    ],
    'code'=>['language'=>'PHP','class'=>'php','filename'=>'request.php','source'=> <<<'CODE'
<?php
session_start();
$acao = $_POST['acao'] ?? '';
if ($acao !== 'salvar') {
    http_response_code(405);
    exit('Método ou ação não aceita.');
}
$descricao = trim((string)($_POST['descricao'] ?? ''));
if ($descricao === '' || mb_strlen($descricao) > 120) {
    http_response_code(422);
    exit('Revise a descrição.');
}
// A regra é verificada no servidor; persista com uma camada apropriada.
CODE
    ,'note'=>'Em produção, trate erros de sessão, valide CSRF para alterações e persista os dados por uma camada segura.'],
  ],
  'php-onde-usar' => [
    'title'=>'PHP em produtos reais','eyebrow'=>'TRILHA 01 · APLICAÇÕES','crumb'=>'PHP / Onde usar','lead'=>'PHP continua presente em produtos, plataformas de conteúdo e sistemas de negócio. O valor está em saber integrar e manter essas aplicações com segurança.','time'=>'7 min de leitura','next'=>['css-index','projetos-index'],
    'sections'=>[
      ['title'=>'Cenários frequentes','body'=> <<<'HTML'
<ul><li><strong>CMS e publicação:</strong> temas, módulos, conteúdo editorial e permissões.</li><li><strong>Comércio eletrônico:</strong> catálogo, carrinho, pedidos, integração e back-office.</li><li><strong>Portais e serviços:</strong> contas, formulários, APIs, relatórios e fluxos administrativos.</li><li><strong>Sistemas legados:</strong> corrigir falhas, integrar novos serviços e modernizar partes de uma aplicação que não pode parar.</li><li><strong>Ferramentas internas:</strong> painéis para automatizar tarefas e reduzir trabalho repetitivo.</li></ul>
HTML],
      ['title'=>'Um caso real de ponta a ponta','body'=> <<<'HTML'
<p>Imagine um painel de solicitações. O navegador envia um formulário; o PHP valida a identidade e os campos, aplica as regras do estado, salva a mudança e responde com uma confirmação. CSS mantém os estados e mensagens legíveis; JavaScript pode avisar sobre campos faltantes sem substituir a validação do servidor.</p><p>Esse exemplo mostra o que equipes esperam: delimitar responsabilidades, proteger acesso, registrar falhas úteis e manter o comportamento verificável. APIs e serviços externos entram por interfaces claras, com credenciais fora do repositório.</p>
HTML],
      ['title'=>'O que mostrar no portfólio','body'=> <<<'HTML'
<p>Documente o problema e o público, o fluxo principal, o modelo de dados, os controles de segurança e uma limitação que você resolveu. Inclua instruções reproduzíveis, imagens próprias do projeto e uma demonstração. Não publique dados reais nem credenciais.</p><p>Pratique com o <a href="/projetos/projeto-crud.php">CRUD</a> e o <a href="/projetos/projeto-login.php">sistema de login</a> desta trilha.</p>
HTML],
    ],
    'code'=>['language'=>'PHP','class'=>'php','filename'=>'status.php','source'=> <<<'CODE'
<?php
$statusPermitidos = ['aberta', 'em_andamento', 'concluida'];
$novoStatus = $_POST['status'] ?? '';
if (!in_array($novoStatus, $statusPermitidos, true)) {
    http_response_code(422);
    exit('Status inválido.');
}
// Verifique autorização e grave a transição na persistência.
CODE
    ,'note'=>'A permissão de quem pode mudar o estado deve ser verificada no servidor, em toda requisição.'],
  ],

  'css-index' => [
    'title'=>'CSS: transforme intenção em interface','eyebrow'=>'TRILHA 02 · FRONTEND','crumb'=>'CSS','lead'=>'CSS controla a apresentação: hierarquia, espaço, tipografia e comportamento em diferentes telas. O segredo profissional é criar regras previsíveis e reutilizáveis.','time'=>'8 min de leitura','badge'=>'CSS','next'=>['css-utilidade','css-como-funciona','css-onde-usar'],
    'sections'=>[
      ['title'=>'CSS é mais que “deixar bonito”','body'=> <<<'HTML'
<p>CSS expressa decisões de interface: quais elementos chamam atenção, como o conteúdo flui, onde surgem estados e como o layout se adapta. Um bom sistema visual ajuda uma pessoa a entender a página e a concluir tarefas com confiança.</p><p>Estruture primeiro o HTML conforme o significado do conteúdo. Depois aplique estilos em camadas pequenas, com tokens para cores, espaçamento e tipografia. Evite lutar contra o browser com seletores excessivamente específicos.</p>
HTML],
      ['title'=>'Quatro ferramentas essenciais','body'=> <<<'HTML'
<ul><li><strong>Cascata e especificidade:</strong> resolvem conflitos e mostram por que uma regra vence outra.</li><li><strong>Box model:</strong> define conteúdo, `padding`, borda e margem; `box-sizing: border-box` simplifica medidas.</li><li><strong>Flexbox:</strong> ótimo para alinhar itens em uma dimensão e distribuir espaço.</li><li><strong>Grid:</strong> organiza linhas e colunas quando a composição pede duas dimensões.</li></ul><p>Use media queries com base no conteúdo, não em uma lista rígida de aparelhos. Verifique foco, contraste, zoom e conteúdo em telas estreitas.</p>
HTML],
      ['title'=>'Experimente um cartão responsivo','body'=> <<<'HTML'
<p>O laboratório abaixo reúne HTML e CSS em um só exemplo. Troque os valores, execute e observe como os estilos mudam. A pré-visualização usa um iframe isolado e só roda no seu navegador.</p>
HTML],
    ],
    'code'=>['language'=>'CSS','class'=>'css','filename'=>'layout.css','source'=> <<<'CODE'
.card-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1rem;
}

.card {
  padding: 1.25rem;
  border: 1px solid #3a3a3a;
  border-radius: 1rem;
  background: #2d2d2d;
}
CODE
    ,'note'=>'`minmax()` com `auto-fit` cria colunas adaptáveis sem exigir uma media query para cada largura.'],
    'lab'=>['hint'=>'Edite o HTML e os estilos dentro da tag <style>; a prévia se adapta à largura disponível.','source'=> <<<'CODE'
<style>
  body { font: 16px system-ui; background: #151922; color: white; padding: 1rem; }
  .card { max-width: 320px; margin: 1rem auto; padding: 1.2rem; border-radius: 16px; background: #25334b; border: 1px solid #4678bd; }
  .card a { color: #93c5fd; }
</style>
<article class="card">
  <p>LABORATÓRIO · CSS</p>
  <h2>Interface responsiva</h2>
  <p>Ajuste cor, borda, espaçamento ou largura para observar o resultado.</p>
  <a href="#" onclick="return false">Ação de demonstração</a>
</article>
CODE
    ],
    'quiz'=>[
      ['question'=>'Qual ferramenta organiza itens em uma única dimensão com alinhamento simples?','options'=>['Flexbox.','A propriedade `alt`.','Uma query SQL.'],'answer'=>0,'explanation'=>'Flexbox é uma ferramenta de layout unidimensional; CSS Grid cobre bem arranjos de duas dimensões.'],
      ['question'=>'O que `box-sizing: border-box` muda?','options'=>['Inclui padding e borda na largura/altura declaradas.','Faz o elemento virar um formulário.','Desativa o layout responsivo.'],'answer'=>0,'explanation'=>'Com border-box, a dimensão declarada já inclui conteúdo, padding e borda.'],
      ['question'=>'Uma media query deve ser escolhida principalmente por quê?','options'=>['Pelo ponto em que o conteúdo/layout deixa de funcionar bem.','Pelo modelo exato do telefone mais vendido.','Pelo nome do arquivo CSS.'],'answer'=>0,'explanation'=>'Priorize o ponto de ruptura em que o layout ou conteúdo pede outro arranjo.'],
    ],
  ],
  'css-utilidade' => [
    'title'=>'Para que usar CSS','eyebrow'=>'TRILHA 02 · CSS','crumb'=>'CSS / Utilidade','lead'=>'Use CSS para tornar a informação compreensível e a interface consistente em diferentes tamanhos de tela e contextos de uso.','time'=>'5 min de leitura','next'=>['css-como-funciona','css-onde-usar'],
    'sections'=>[
      ['title'=>'A utilidade principal','body'=> <<<'HTML'
<p>CSS separa o significado do conteúdo de sua apresentação. O mesmo HTML pode aparecer como coluna no desktop e pilha no celular. Cores, tipografia e espaçamento podem refletir o estado da interface sem mudar o conteúdo nem duplicar marcação.</p><p>Ao estruturar estilos, prefira padrões de layout claros, variáveis de design e regras próximas ao componente. Assim, equipes conseguem evoluir uma interface sem corrigir centenas de exceções.</p>
HTML],
      ['title'=>'Uso diário no produto','body'=> <<<'HTML'
<ul><li>Definir hierarquia visual entre títulos, detalhes, mensagens e ações.</li><li>Adaptar navegação, tabelas, formulários e cartões às larguras disponíveis.</li><li>Mostrar estados de foco, seleção, erro, carregamento e conclusão.</li><li>Padronizar componentes e manter consistência entre muitas páginas.</li><li>Adicionar transições curtas que esclarecem uma mudança sem atrasar a tarefa.</li></ul>
HTML],
      ['title'=>'Consistência é uma decisão técnica','body'=> <<<'HTML'
<p>Crie tokens para cores e espaçamento e use nomes que expressem função, como `--color-surface` ou `--space-4`. Evite codificar valores aleatórios em cada seletor. Garanta que uma pessoa consiga aumentar o zoom e continuar lendo; movimento não deve ser obrigatório para entender um estado.</p>
HTML],
    ],
    'code'=>['language'=>'CSS','class'=>'css','filename'=>'tokens.css','source'=> <<<'CODE'
:root {
  --color-surface: #242a35;
  --color-text: #f3f4f6;
  --color-accent: #3b82f6;
  --space-1: .5rem;
  --space-2: 1rem;
}
.button { color: var(--color-text); background: var(--color-accent); }
CODE
    ,'note'=>'Tokens facilitam manutenção: a interface muda de forma coerente quando uma decisão de design muda.'],
  ],
  'css-como-funciona' => [
    'title'=>'A cascata, o box model e o layout','eyebrow'=>'TRILHA 02 · CSS','crumb'=>'CSS / Como funciona','lead'=>'Entender como o navegador resolve regras poupa tempo de depuração e reduz estilos frágeis.','time'=>'8 min de leitura','next'=>['css-onde-usar','javascript-index'],
    'sections'=>[
      ['title'=>'Por que uma regra vence','body'=> <<<'HTML'
<p>Quando várias declarações afetam a mesma propriedade, o navegador aplica origem, importância, especificidade e ordem conforme a cascata. IDs têm especificidade maior que classes; classes e atributos superam seletores de elemento. A última regra só vence quando os demais critérios empatam.</p><p>Se a solução exige muitos `!important` ou um seletor muito longo, investigue o conflito em vez de adicionar outra camada. Ferramentas de desenvolvedor mostram a regra aplicada e a que foi sobrescrita.</p>
HTML],
      ['title'=>'Box model e layout','body'=> <<<'HTML'
<p>Por padrão, `content-box` soma conteúdo, padding e bordas à dimensão declarada. Muitos projetos preferem aplicar `box-sizing: border-box` globalmente. Use Grid para definir estrutura em linhas/colunas e Flexbox para alinhar elementos ao longo de um eixo; use posicionamento apenas quando existir uma relação clara com o contêiner.</p>
HTML],
      ['title'=>'Responsividade e acessibilidade','body'=> <<<'HTML'
<p>Layouts fluidos, unidades relativas e media queries bem escolhidas permitem que o conteúdo se ajuste sem exigir versões duplicadas. Mantenha foco do teclado visível, use contraste suficiente e não esconda instruções apenas atrás de hover. Se a animação não é essencial, respeite a preferência de movimento reduzido.</p>
HTML],
    ],
    'code'=>['language'=>'CSS','class'=>'css','filename'=>'base.css','source'=> <<<'CODE'
*, *::before, *::after { box-sizing: border-box; }

.layout {
  display: grid;
  grid-template-columns: 16rem minmax(0, 1fr);
  gap: clamp(1rem, 4vw, 3rem);
}

@media (max-width: 48rem) {
  .layout { grid-template-columns: 1fr; }
}
CODE
    ,'note'=>'O limite da media query é um exemplo. Escolha o ponto em que o conteúdo do seu produto pede outra composição.'],
  ],
  'css-onde-usar' => [
    'title'=>'CSS no mercado de trabalho','eyebrow'=>'TRILHA 02 · APLICAÇÕES','crumb'=>'CSS / Onde usar','lead'=>'CSS é parte do trabalho em produto digital, design systems, ferramentas internas e interfaces de conteúdo.','time'=>'6 min de leitura','next'=>['javascript-index','projetos-index'],
    'sections'=>[
      ['title'=>'Trabalho que equipes realmente fazem','body'=> <<<'HTML'
<ul><li>Implementar telas a partir de requisitos, protótipos e conteúdo real.</li><li>Construir componentes reutilizáveis para navegação, cards, formulários e feedback.</li><li>Corrigir comportamento em resoluções diferentes, zoom e navegação por teclado.</li><li>Manter design systems com tokens, variantes e regras consistentes.</li><li>Reduzir regressões visuais e peso de CSS que bloqueia ou conflita.</li></ul>
HTML],
      ['title'=>'Qualidade é mais que pixel perfeito','body'=> <<<'HTML'
<p>Profissionais traduzem a intenção do layout sem sacrificar semântica e acessibilidade. Verificam estados vazios, erro e carregamento, texto longo e contraste. Ao entregar um componente, deixam claro quais dados e estados ele suporta.</p><p>Em revisões, explique por que escolheu Grid ou Flexbox, de onde vêm as cores e que larguras foram verificadas. Um componente simples e previsível costuma ser melhor do que uma coleção de ajustes para uma única captura de tela.</p>
HTML],
      ['title'=>'Um exercício de portfólio','body'=> <<<'HTML'
<p>Crie um pequeno catálogo com filtros, cartões e estados vazios. Inclua foco de teclado, layouts para telas estreitas e uma explicação de seus tokens. Você pode praticar parte desse raciocínio no <a href="/projetos/index.php">catálogo de projetos</a>.</p>
HTML],
    ],
    'code'=>['language'=>'CSS','class'=>'css','filename'=>'focus.css','source'=> <<<'CODE'
.button {
  background: #3b82f6;
  border-radius: .75rem;
  transition: background-color .18s ease, transform .18s ease;
}
.button:hover { background: #60a5fa; }
.button:focus-visible { outline: 3px solid #bfdbfe; outline-offset: 3px; }
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
}
CODE
    ,'note'=>'Foco visível e movimento reduzido fazem parte da experiência; não são acabamento opcional.'],
  ],

  'javascript-index' => [
    'title'=>'JavaScript: faça a interface responder','eyebrow'=>'TRILHA 03 · INTERAÇÃO','crumb'=>'JavaScript','lead'=>'JavaScript conecta ações do usuário a mudanças na interface e integra dados da rede. Aprenda a controlar efeitos e manter o estado previsível.','time'=>'8 min de leitura','badge'=>'JS','next'=>['javascript-utilidade','javascript-como-funciona','javascript-onde-usar'],
    'sections'=>[
      ['title'=>'Do evento à resposta','body'=> <<<'HTML'
<p>O navegador carrega HTML e CSS; JavaScript pode localizar elementos, escutar eventos, validar o estado da interface e atualizar o conteúdo. Uma ação, como clicar em “adicionar”, pode mudar uma lista sem carregar outra página. Quando precisa de dados do servidor, JavaScript envia uma requisição HTTP e trata a resposta assíncrona.</p><p>Não esconda conteúdo essencial apenas no JavaScript sem motivo. Use HTML semântico como base, faça estados claros e atualize o mínimo necessário. Separe comportamento em funções com nomes que revelem intenção.</p>
HTML],
      ['title'=>'Estado, eventos e rede','body'=> <<<'HTML'
<ul><li><strong>DOM:</strong> representação em memória dos elementos da página.</li><li><strong>Eventos:</strong> notificações de interação, como clique, teclado ou envio de formulário.</li><li><strong>Estado:</strong> os dados que determinam o que a interface deve mostrar.</li><li><strong>Promise e async/await:</strong> formas de coordenar trabalho que termina depois, como chamadas de rede.</li></ul><p>Ao renderizar texto fornecido por uma pessoa, prefira `textContent` a `innerHTML`. Trate falhas de rede, desabilite ações durante o envio e comunique o resultado.</p>
HTML],
      ['title'=>'Execute uma interação segura','body'=> <<<'HTML'
<p>Edite o trecho no playground. O código roda em um iframe isolado neste navegador. Nada do que você escreve é enviado ao portal.</p>
HTML],
    ],
    'code'=>['language'=>'JavaScript','class'=>'js','filename'=>'contador.js','source'=> <<<'CODE'
const botao = document.querySelector('#adicionar');
const saida = document.querySelector('#valor');
let total = 0;

botao.addEventListener('click', () => {
  total += 1;
  saida.textContent = String(total);
});
CODE
    ,'note'=>'`textContent` insere texto sem interpretá-lo como HTML.'],
    'lab'=>['hint'=>'Clique no botão da prévia para ver o evento atualizando o DOM. Edite o HTML/JavaScript e execute novamente.','source'=> <<<'CODE'
<div style="font:16px system-ui;background:#171b25;color:#f8fafc;padding:24px;border-radius:16px">
  <p style="color:#93c5fd">LABORATÓRIO · JAVASCRIPT</p>
  <h2>Cliques: <span id="contador">0</span></h2>
  <button id="somar" style="background:#3b82f6;color:white;border:0;border-radius:8px;padding:10px 14px;cursor:pointer">Somar 1</button>
</div>
<script>
let total = 0;
document.querySelector('#somar').addEventListener('click', () => {
  total += 1;
  document.querySelector('#contador').textContent = total;
});
</script>
CODE
    ],
    'quiz'=>[
      ['question'=>'O que o DOM representa?','options'=>['Uma representação dos elementos do documento que o código pode consultar e atualizar.','Um banco de dados externo.','Uma propriedade exclusiva do CSS.'],'answer'=>0,'explanation'=>'O DOM é a representação em memória da estrutura do documento.'],
      ['question'=>'Por que escolher `textContent` para mostrar texto digitado?','options'=>['Ele adiciona uma imagem automaticamente.','Ele evita interpretar o texto como marcação HTML.','Ele envia os dados ao servidor.'],'answer'=>1,'explanation'=>'textContent trata a entrada como texto, em vez de inseri-la como HTML.'],
      ['question'=>'Qual recurso é apropriado para uma chamada de rede assíncrona?','options'=>['Promise com tratamento de sucesso e erro.','Somente uma regra CSS.','Uma imagem de fundo.'],'answer'=>0,'explanation'=>'Promises representam operações que podem terminar depois, tanto com sucesso quanto com falha.'],
    ],
  ],
  'javascript-utilidade' => [
    'title'=>'Para que usar JavaScript','eyebrow'=>'TRILHA 03 · JAVASCRIPT','crumb'=>'JavaScript / Utilidade','lead'=>'JavaScript atende comportamentos no cliente e, em ambientes adequados, também serviços no servidor. Use quando o produto precisa reagir a eventos ou integrar dados.','time'=>'5 min de leitura','next'=>['javascript-como-funciona','javascript-onde-usar'],
    'sections'=>[
      ['title'=>'A utilidade principal','body'=> <<<'HTML'
<p>No navegador, JavaScript coordena eventos, atualiza estados, apresenta resultados e conversa com APIs. Em um servidor Node.js, a mesma linguagem pode implementar APIs e ferramentas. A linguagem não substitui PHP neste portal; as duas têm ecossistemas diferentes e podem participar de sistemas distintos.</p><p>Se uma interação pode ser resolvida com HTML nativo, não adicione script sem necessidade. Se uma regra precisa ser confiável contra clientes modificados, mantenha-a no servidor.</p>
HTML],
      ['title'=>'Exemplos no produto','body'=> <<<'HTML'
<ul><li>Validar formato de campos e dar retorno rápido antes do envio.</li><li>Pesquisar ou filtrar uma lista já carregada.</li><li>Atualizar indicadores e componentes com base em eventos.</li><li>Enviar formulários sem recarregar a página, quando a experiência justificar.</li><li>Consumir APIs e apresentar carregamento, erro e dados vazios.</li></ul>
HTML],
      ['title'=>'O servidor continua sendo a autoridade','body'=> <<<'HTML'
<p>Uma interface pode ocultar um botão, mas isso não protege a operação. O cliente controla o próprio navegador; permissões, preços e transições importantes precisam de verificação no servidor. Nunca envie tokens privados para o JavaScript público.</p>
HTML],
    ],
    'code'=>['language'=>'JavaScript','class'=>'js','filename'=>'busca.js','source'=> <<<'CODE'
const campo = document.querySelector('#busca');
const itens = [...document.querySelectorAll('[data-item]')];

campo.addEventListener('input', () => {
  const termo = campo.value.trim().toLocaleLowerCase('pt-BR');
  itens.forEach((item) => {
    item.hidden = !item.textContent.toLocaleLowerCase('pt-BR').includes(termo);
  });
});
CODE
    ,'note'=>'Filtragem local é útil para listas pequenas já carregadas; pesquisa grande normalmente pede suporte do servidor.'],
  ],
  'javascript-como-funciona' => [
    'title'=>'DOM, eventos e trabalho assíncrono','eyebrow'=>'TRILHA 03 · JAVASCRIPT','crumb'=>'JavaScript / Como funciona','lead'=>'Entenda como organizar eventos e estado sem criar comportamentos que se contradizem ou perdem dados.','time'=>'8 min de leitura','next'=>['javascript-onde-usar','deploy-render'],
    'sections'=>[
      ['title'=>'Eventos e fluxo de interface','body'=> <<<'HTML'
<p>O navegador executa o JavaScript e oferece APIs para consultar o documento, escutar eventos e agendar trabalho. Um listener registra o que fazer quando o evento ocorre. Evite registrar listeners repetidos em cada renderização; delegação de eventos pode simplificar listas dinâmicas.</p><p>Guarde os dados que representam a interface em um estado explícito. Mude o estado em resposta ao evento e então atualize os elementos relacionados. Assim, várias ações não deixam o DOM em um estado incompatível.</p>
HTML],
      ['title'=>'Assíncrono sem congelar a tela','body'=> <<<'HTML'
<p>Uma requisição de rede demora e pode falhar. `async/await` deixa o fluxo de Promise mais legível, mas precisa de tratamento de erro e estado de carregamento. Não assuma que a resposta vem antes da próxima linha; o restante da página continua disponível enquanto a operação aguarda.</p>
HTML],
      ['title'=>'Defesa em profundidade','body'=> <<<'HTML'
<ul><li>Use `textContent` para texto; evite montar HTML a partir de entrada sem uma sanitização confiável.</li><li>Faça validações no cliente para ajudar, mas repita as regras relevantes no servidor.</li><li>Trate `response.ok`, exceções e estados vazios em chamadas HTTP.</li><li>Evite variáveis globais; agrupe dados e comportamento por módulo ou escopo.</li></ul>
HTML],
    ],
    'code'=>['language'=>'JavaScript','class'=>'js','filename'=>'carregar.js','source'=> <<<'CODE'
async function carregarPerfil(id) {
  const resposta = await fetch(`/api/perfis/${encodeURIComponent(id)}`);
  if (!resposta.ok) throw new Error('Não foi possível carregar o perfil.');
  return resposta.json();
}

carregarPerfil('42')
  .then((perfil) => { document.querySelector('#nome').textContent = perfil.nome; })
  .catch((erro) => { console.error(erro); });
CODE
    ,'note'=>'Uma API real deve autorizar acesso no servidor; ocultar um link no cliente não impede uma requisição direta.'],
  ],
  'javascript-onde-usar' => [
    'title'=>'JavaScript em produtos reais','eyebrow'=>'TRILHA 03 · APLICAÇÕES','crumb'=>'JavaScript / Onde usar','lead'=>'JavaScript aparece em interfaces web, ferramentas internas, dashboards e serviços. O que diferencia uma boa implementação é o comportamento previsível.','time'=>'6 min de leitura','next'=>['vscode-instalacao','projetos-index'],
    'sections'=>[
      ['title'=>'Casos de uso no mercado','body'=> <<<'HTML'
<ul><li><strong>Produtos web:</strong> busca, formulários guiados, menus, filtros e atualizações de estado.</li><li><strong>Dashboards:</strong> seleção de período, gráficos e atualização de indicadores.</li><li><strong>Ferramentas internas:</strong> reduzir passos repetidos com interfaces de operação.</li><li><strong>APIs e serviços:</strong> ambientes JavaScript de servidor podem processar requisições e tarefas.</li><li><strong>Integrações:</strong> consumir serviços e lidar com respostas, limites e erros.</li></ul>
HTML],
      ['title'=>'Experiência consistente','body'=> <<<'HTML'
<p>A equipe espera que uma ação mostre carregamento quando necessário, sucesso somente depois da confirmação e erro com próxima orientação. Evite double-submit, preserve entrada quando uma chamada falhar e não marque a tarefa como concluída antes da resposta confiável do servidor.</p>
HTML],
      ['title'=>'Apresente escolhas, não só efeitos','body'=> <<<'HTML'
<p>Num portfólio, explique qual estado sua interface mantém, o que acontece durante uma falha e por que escolheu atualização local ou requisição remota. Demonstre que conhece limites de segurança, acessibilidade e desempenho.</p>
HTML],
    ],
    'code'=>['language'=>'JavaScript','class'=>'js','filename'=>'estado.js','source'=> <<<'CODE'
const form = document.querySelector('#formulario');
const aviso = document.querySelector('#aviso');

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  aviso.textContent = 'Salvando…';
  try {
    const resposta = await fetch('/api/itens', { method: 'POST', body: new FormData(form) });
    if (!resposta.ok) throw new Error('Falha no envio');
    aviso.textContent = 'Salvo com sucesso.';
  } catch {
    aviso.textContent = 'Não foi possível salvar. Seus campos continuam aqui.';
  }
});
CODE
    ,'note'=>'A validação de permissão e os dados persistidos continuam sendo responsabilidade do servidor.'],
  ],

  'vscode-instalacao' => [
    'title'=>'Prepare o VS Code','eyebrow'=>'FERRAMENTAS · PRIMEIRO PASSO','crumb'=>'VS Code / Instalação','lead'=>'Configure um editor confortável sem transformar a preparação em uma maratona de extensões.','time'=>'5 min de leitura','next'=>['vscode-estrutura','vscode-servidor'],
    'sections'=>[
      ['title'=>'Instale e abra uma pasta','body'=> <<<'HTML'
<ol><li>Baixe Visual Studio Code apenas do <a href="https://code.visualstudio.com/download" target="_blank" rel="noopener">site oficial</a> e conclua a instalação para seu sistema.</li><li>Abra o editor e escolha <strong>File → Open Folder</strong>; abrir a pasta evita perder a relação entre arquivos.</li><li>Crie uma pasta de projeto separada dos seus downloads e confirme o nome no Explorer lateral.</li><li>Abra o terminal integrado em <strong>Terminal → New Terminal</strong> e confira a pasta atual.</li></ol><p>O VS Code é o editor; ele não instala PHP por padrão. Você precisa de um interpretador PHP disponível no PATH ou de um ambiente como Docker.</p>
HTML],
      ['title'=>'Extensões: comece pelo necessário','body'=> <<<'HTML'
<ul><li><strong>PHP Intelephense:</strong> navegação, conclusão e diagnósticos para PHP.</li><li><strong>EditorConfig:</strong> mantém indentação e espaçamento coerentes com o repositório.</li><li><strong>Prettier:</strong> formatação consistente para CSS, HTML e JavaScript; configure o projeto antes de adotá-lo.</li><li><strong>GitLens, opcional:</strong> ajuda a inspecionar histórico e autoria do Git.</li></ul><p>Instale uma extensão de cada vez, avalie se agrega e confira permissões e publicador. Evite extensões duplicadas que disputam formatação.</p>
HTML],
      ['title'=>'Ajuste o ciclo de trabalho','body'=> <<<'HTML'
<p>Use o painel de busca de arquivos, mantenha a formatação consistente e execute o programa a partir da raiz do projeto. Guarde credenciais fora do Git, confira `git status` antes de publicar e leia os erros completos do terminal.</p>
HTML],
    ],
    'code'=>['language'=>'Bash','class'=>'bash','filename'=>'terminal-integrado.sh','source'=> <<<'CODE'
# Entre na pasta que você abriu no VS Code:
pwd

# Veja os arquivos do projeto:
ls -la

# Se PHP estiver instalado, consulte a versão:
php --version
CODE
    ,'note'=>'No Windows, use PowerShell ou WSL conforme seu ambiente; adapte comandos como `ls` quando necessário.'],
  ],
  'vscode-estrutura' => [
    'title'=>'Organize um projeto PHP','eyebrow'=>'FERRAMENTAS · ESTRUTURA','crumb'=>'VS Code / Estrutura','lead'=>'Uma estrutura pequena com responsabilidades claras ajuda outra pessoa a entender e alterar o projeto.','time'=>'6 min de leitura','next'=>['vscode-servidor','deploy-render'],
    'sections'=>[
      ['title'=>'Comece simples e expanda por necessidade','body'=> <<<'HTML'
<p>Separe páginas, includes, estilos, scripts e arquivos públicos. Um include reutilizável reduz duplicação, mas não deve misturar toda a aplicação em um arquivo gigantesco. Mantenha os caminhos previsíveis e adicione novas camadas quando houver uma necessidade concreta.</p><p>Não armazene arquivos privados no diretório servido pelo servidor web. Segredos ficam em variáveis de ambiente e não entram no repositório.</p>
HTML],
      ['title'=>'Árvore inicial recomendada','body'=> <<<'HTML'
<pre class="tree-block"><code>meu-app/
├── index.php
├── includes/
│   ├── config.php
│   ├── header.php
│   └── footer.php
├── assets/
│   ├── css/style.css
│   └── js/main.js
├── storage/          # não público; se necessário
├── Dockerfile
└── README.md</code></pre>
<p>Use `require_once` para dependências essenciais, `__DIR__` para caminhos estáveis e funções pequenas para responsabilidades repetidas.</p>
HTML],
      ['title'=>'Boas práticas no repositório','body'=> <<<'HTML'
<ul><li>Descreva como rodar, variáveis necessárias e decisões de arquitetura no README.</li><li>Inclua um `.gitignore` para ambiente local, logs, dependências e arquivos privados.</li><li>Use nomes previsíveis para rotas, funções, variáveis e pastas.</li><li>Revise diferenças do Git, remova dados de teste e não versione segredos.</li></ul>
HTML],
    ],
    'code'=>['language'=>'PHP','class'=>'php','filename'=>'index.php','source'=> <<<'CODE'
<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/header.php';
?>
<main>
  <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
CODE
    ,'note'=>'`__DIR__` ancora o caminho ao arquivo atual; escapar saída continua importante mesmo em um projeto pequeno.'],
  ],
  'vscode-servidor' => [
    'title'=>'Rode PHP localmente','eyebrow'=>'FERRAMENTAS · EXECUÇÃO','crumb'=>'VS Code / Servidor local','lead'=>'Teste páginas no servidor local e use os logs para entender a diferença entre código de navegador e código de backend.','time'=>'5 min de leitura','next'=>['deploy-render','projetos-index'],
    'sections'=>[
      ['title'=>'Use o servidor embutido para aprender','body'=> <<<'HTML'
<p>Instale PHP CLI para seu sistema operacional e confirme com `php --version`. No terminal integrado, entre na raiz do projeto e execute o servidor embutido do PHP. Use-o para desenvolvimento, não como servidor público de produção.</p><p>O comando `php -S 127.0.0.1:8000` deixa o servidor acessível apenas localmente. Para este projeto no Preview ou dentro de um container, o endereço de escuta é definido pelo ambiente; no Render deve ser público em `0.0.0.0` e respeitar `PORT`.</p>
HTML],
      ['title'=>'Comando e verificação rápida','body'=> <<<'HTML'
<p>Com o terminal na pasta do projeto, rode o comando abaixo, abra a URL exibida no navegador e carregue um arquivo PHP. Se o navegador mostrar `<?php` sem processar, o pedido não está passando por um interpretador PHP.</p>
HTML],
      ['title'=>'Depure com uma hipótese','body'=> <<<'HTML'
<ul><li>Confirme diretório atual, nome e permissões do arquivo.</li><li>Leia a mensagem do terminal; erros de sintaxe podem ser conferidos com `php -l arquivo.php`.</li><li>Verifique status HTTP e aba Network para arquivos não encontrados.</li><li>Não publique `phpinfo()` em um serviço público: a página pode expor detalhes do ambiente.</li></ul>
HTML],
    ],
    'code'=>['language'=>'Bash','class'=>'bash','filename'=>'rodar-local.sh','source'=> <<<'CODE'
# Execute na raiz que contém index.php:
php -S 127.0.0.1:8000

# Em outro terminal, valide sintaxe de um arquivo:
php -l index.php
CODE
    ,'note'=>'Para disponibilizar um serviço em container público, escute em 0.0.0.0 e na porta PORT.'],
  ],

  'deploy-render' => [
    'title'=>'Do GitHub ao Render','eyebrow'=>'PUBLICAÇÃO · DO DESENVOLVIMENTO À WEB','crumb'=>'Deploy / Render','lead'=>'O Render oferece uma rota prática para PHP com Docker: o container define o runtime, e o Web Service disponibiliza o processo HTTP.','time'=>'10 min de leitura','next'=>['projetos-index','mercado-index'],
    'sections'=>[
      ['title'=>'1 · Prepare e envie o repositório','body'=> <<<'HTML'
<ol><li>Na raiz, mantenha o `Dockerfile`, o código PHP, o `.dockerignore` e um README com os passos de execução.</li><li>Teste localmente os arquivos e remova credenciais, dados pessoais e pastas temporárias do commit.</li><li>Crie um repositório GitHub e faça push para a branch que será implantada. Revise os arquivos versionados antes de publicar.</li></ol><p>Para este portal, o repositório já inclui um Dockerfile baseado em PHP/Apache e o manifesto `render.yaml`, que você pode usar como ponto de partida.</p>
HTML],
      ['title'=>'2 · Crie o Web Service no Render','body'=> <<<'HTML'
<ol><li>No dashboard Render, escolha <strong>New → Web Service</strong> e conecte o repositório GitHub.</li><li>Defina a raiz do projeto. Em Environment/Language, selecione <strong>Docker</strong> e informe o caminho do Dockerfile, se ele não estiver na raiz.</li><li>Configure o serviço e a health check path como `/`. O Dockerfile do portal prepara PHP e Apache; o serviço não precisa de banco de dados.</li><li>Inicie o deploy. Acompanhe build e runtime na página de eventos/logs do serviço.</li></ol><p>A configuração oficial de serviços Docker do Render permite construir a imagem usando o Dockerfile do repositório. PHP é um caso de uso adequado quando é necessário um runtime fora dos nativos oferecidos.</p>
HTML],
      ['title'=>'3 · Confira porta e escuta','body'=> <<<'HTML'
<p>Um Web Service precisa escutar em <code>0.0.0.0</code>. O padrão esperado pelo Render é a variável <code>PORT</code> (normalmente <code>10000</code>); use essa variável em vez de fixar uma porta que conflite com a plataforma. Este projeto atualiza a porta do Apache no início do container.</p><p>Se a aplicação não iniciar, confira primeiro os logs de inicialização, se o container está ouvindo na porta de ambiente e se a resposta HTTP de `/` retorna sucesso. As requisições chegam ao container por HTTP; TLS é encerrado na infraestrutura do Render.</p>
HTML],
      ['title'=>'4 · Valide a publicação','body'=> <<<'HTML'
<ol><li>Abra a URL pública exibida pelo Render e confirme que a página inicial carrega.</li><li>Navegue para trilhas PHP, CSS e JavaScript, teste a busca e confirme que progresso e feedback continuam disponíveis no mesmo navegador.</li><li>Baixe os ZIPs de projetos e confirme que o navegador iniciou o download.</li><li>Em CSS/JavaScript, execute os playgrounds e confirme a prévia; os iframes são isolados e locais.</li><li>Se o deploy falhar, leia os logs, corrija o erro e faça push de uma nova alteração.</li></ol><p>Conteúdo em <code>localStorage</code> fica no dispositivo e não é enviado ao servidor. Para autenticação multiusuário ou persistência entre aparelhos, seria necessária uma base de dados e um desenho de segurança adicional.</p>
HTML],
      ['title'=>'Documentação usada neste guia','body'=> <<<'HTML'
<p>As instruções do Render podem evoluir. Confira as páginas oficiais antes de alterar a configuração:</p><ul><li><a href="https://render.com/docs/docker" target="_blank" rel="noopener">Docker on Render</a> — construção e configuração do container.</li><li><a href="https://render.com/docs/web-services" target="_blank" rel="noopener">Web Services</a> — como criar serviço e configurar porta/escuta.</li><li><a href="https://render.com/docs/deploy-php-laravel-docker" target="_blank" rel="noopener">Deploy a PHP Web App with Docker</a> — exemplo oficial de PHP.</li></ul>
HTML],
    ],
    'code'=>['language'=>'Dockerfile','class'=>'docker','filename'=>'Dockerfile','source'=> <<<'CODE'
FROM php:8.3-apache
WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/portal-entrypoint
RUN chmod +x /usr/local/bin/portal-entrypoint
EXPOSE 10000
ENTRYPOINT ["portal-entrypoint"]
CMD ["apache2-foreground"]
CODE
    ,'note'=>'O entrypoint incluído neste repositório ajusta a porta do Apache para a variável PORT fornecida em runtime.'],
  ],

  'projetos-index' => [
    'title'=>'Aprenda terminando','eyebrow'=>'LABORATÓRIO · PROJETOS','crumb'=>'Projetos','lead'=>'Projetos pequenos e completos ensinam mais que trechos desconectados. Baixe o código, leia o README e acrescente uma melhoria própria.','time'=>'4 min de leitura','next'=>['projeto-crud','projeto-login'],
    'sections'=>[
      ['title'=>'O que você vai praticar','body'=> <<<'HTML'
<p>Os dois projetos integram formulário, PHP, HTML, CSS e validação. A persistência local em JSON ajuda a estudar sem configurar um banco. É uma escolha didática: em uma aplicação maior, avalie banco transacional, backup, concorrência e monitoramento.</p>
HTML],
      ['title'=>'Desafio 01 · CRUD de tarefas','body'=> <<<'HTML'
<p>Crie, leia, edite e remova itens. O pacote demonstra validação simples, escape de saída e escrita de JSON no servidor local. Evolua incluindo filtro de estado, paginação e testes para regras do domínio.</p><p><a href="/projetos/projeto-crud.php">Ver explicação do CRUD</a> · <a class="download-link" href="/projetos/downloads/trilhacode-crud.zip" download>Baixar projeto CRUD (.zip) ↓</a></p>
HTML],
      ['title'=>'Desafio 02 · Cadastro e sessão','body'=> <<<'HTML'
<p>Implemente cadastro e entrada usando `password_hash`, `password_verify`, sessão e CSRF. O código é demonstração local: antes de uso em produção, faça revisão de segurança e mova persistência/segredos para uma arquitetura apropriada.</p><p><a href="/projetos/projeto-login.php">Ver explicação do login</a> · <a class="download-link" href="/projetos/downloads/trilhacode-login.zip" download>Baixar projeto Login (.zip) ↓</a></p>
HTML],
      ['title'=>'Como estudar o código','body'=> <<<'HTML'
<ol><li>Leia o README do ZIP e execute sem alterar arquivos.</li><li>Desenhe o fluxo da página, do formulário à resposta.</li><li>Procure validação, controle de acesso e escape de saída.</li><li>Altere um comportamento, teste erro e sucesso e registre o motivo no seu README.</li></ol>
HTML],
    ],
  ],
  'projeto-crud' => [
    'title'=>'Projeto prático: CRUD de tarefas','eyebrow'=>'PROJETO 01 · DADOS E OPERAÇÕES','crumb'=>'Projetos / CRUD','lead'=>'CRUD significa criar, ler, atualizar e excluir. O exercício organiza essas ações num fluxo pequeno e reproduzível.','time'=>'7 min de leitura','next'=>['projeto-login','mercado-index'],
    'sections'=>[
      ['title'=>'O que a aplicação faz','body'=> <<<'HTML'
<p>Uma lista de tarefas recebe texto, cria um identificador, mostra registros e permite alterar ou remover. O exemplo baixável usa um arquivo JSON como persistência local para evitar dependências. O servidor valida os campos e escapa o texto apresentado.</p><p>JSON em arquivo é didático, mas sofre com escrita simultânea, busca e consultas. Para um serviço com usuários e uso concorrente, escolha uma base de dados e acrescente autorização.</p>
HTML],
      ['title'=>'Uma forma de decompor o fluxo','body'=> <<<'HTML'
<ol><li>Leia a ação solicitada e valide o método HTTP.</li><li>Confirme que o identificador existe e tem formato esperado.</li><li>Valide a regra do domínio antes de salvar.</li><li>Persista a alteração de forma controlada.</li><li>Redirecione para evitar reenvio de formulário e mostre um resultado acessível.</li></ol><p>Ao praticar, tente extrair funções de leitura/escrita e manter a view responsável só por apresentar dados.</p>
HTML],
      ['title'=>'Baixe e amplie','body'=> <<<'HTML'
<p><a class="download-link" href="/projetos/downloads/trilhacode-crud.zip" download>Baixar os arquivos do CRUD (.zip) ↓</a>. Depois adicione categorias ou datas de vencimento, valide regras e escreva testes. Mantenha o arquivo de dados fora de um diretório público ao adaptar o projeto.</p>
HTML],
    ],
    'code'=>['language'=>'PHP','class'=>'php','filename'=>'funcoes-crud.php','source'=> <<<'CODE'
<?php
function validarTitulo(string $titulo): string
{
    $titulo = trim($titulo);
    if ($titulo === '' || mb_strlen($titulo) > 120) {
        throw new InvalidArgumentException('Informe um título de até 120 caracteres.');
    }
    return $titulo;
}

// Escape quando renderizar: htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8');
CODE
    ,'note'=>'A validação não elimina a necessidade de escapar saída; são etapas diferentes da proteção.'],
  ],
  'projeto-login' => [
    'title'=>'Projeto prático: login responsável','eyebrow'=>'PROJETO 02 · AUTENTICAÇÃO','crumb'=>'Projetos / Login','lead'=>'Estude o fluxo de cadastro e sessão e reconheça as responsabilidades que não podem ser tratadas como um simples formulário.','time'=>'8 min de leitura','next'=>['mercado-index','deploy-render'],
    'sections'=>[
      ['title'=>'O que o pacote demonstra','body'=> <<<'HTML'
<p>O projeto permite cadastro e login local; armazena hash de senha e usa sessão para identificar uma pessoa autenticada. Inclui token CSRF nos formulários de alteração e troca o identificador da sessão depois do login. Baixe e leia primeiro o README.</p><p><a class="download-link" href="/projetos/downloads/trilhacode-login.zip" download>Baixar arquivos do login (.zip) ↓</a></p>
HTML],
      ['title'=>'O que não pode ser omitido','body'=> <<<'HTML'
<ul><li>Nunca armazene nem registre senha em texto puro.</li><li>Use `password_hash` e `password_verify`, sem inventar criptografia própria.</li><li>Proteja formulários de alteração com validação CSRF.</li><li>Regere identificador de sessão após autenticação e configure cookies com atributos apropriados.</li><li>Limite tentativas e trate mensagens sem revelar se uma conta existe.</li><li>Use HTTPS e recuperação de conta segura antes de publicar para usuários reais.</li></ul>
HTML],
      ['title'=>'Limites da demonstração','body'=> <<<'HTML'
<p>O pacote salva registros em JSON para estudo no computador. Essa estratégia não é suficiente para autenticação de produção com tráfego concorrente. Antes de publicar, inclua revisão de segurança, armazenamento de sessão apropriado, persistência confiável, política de privacidade, proteção contra abuso e monitoramento. Não reutilize senhas de verdade em exercícios.</p>
HTML],
    ],
    'code'=>['language'=>'PHP','class'=>'php','filename'=>'autenticacao.php','source'=> <<<'CODE'
<?php
$hash = password_hash($senha, PASSWORD_DEFAULT);

if (password_verify($senhaInformada, $hashArmazenado)) {
    session_regenerate_id(true);
    $_SESSION['usuario_id'] = $usuario['id'];
}
CODE
    ,'note'=>'O exemplo é educacional. Autenticação publicada exige revisão do armazenamento, cookies, abuso, recuperação de conta e infraestrutura.'],
  ],

  'mercado-index' => [
    'title'=>'Leve prática para o mercado','eyebrow'=>'CARREIRA · PRÓXIMOS PASSOS','crumb'=>'Mercado de trabalho','lead'=>'Equipes procuram quem resolve problemas e comunica escolhas. Transforme o que estudou em evidência concreta do seu processo.','time'=>'7 min de leitura','next'=>['projetos-index','deploy-render'],
    'sections'=>[
      ['title'=>'Construa um portfólio que conta uma história','body'=> <<<'HTML'
<ol><li>Escolha um problema simples de um público real, sem copiar uma tela sem contexto.</li><li>Escreva objetivo, usuário, fluxo principal e critério de sucesso.</li><li>Implemente um recorte concluído com HTML, CSS, JavaScript e PHP onde fizer sentido.</li><li>Inclua acessibilidade, validação, estados de erro e dados fictícios.</li><li>Publique demonstração e repositório com README de instalação e decisões.</li></ol>
HTML],
      ['title'=>'Competências demonstráveis','body'=> <<<'HTML'
<ul><li><strong>Fundamentos:</strong> HTTP, semântica, DOM, cascata, sessões e validação.</li><li><strong>Qualidade:</strong> Git, depuração, testes de regra, segurança de saída e leitura de logs.</li><li><strong>Produto:</strong> comunicação, priorização, experiência em diferentes telas e decisões explicadas.</li><li><strong>Entrega:</strong> deploy, documentação, variáveis de ambiente e recuperação de falhas simples.</li></ul><p>Descreva impacto com honestidade. Diferencie o que está funcionando, o que é protótipo e o que você mudaria com mais tempo.</p>
HTML],
      ['title'=>'Prepare uma conversa técnica','body'=> <<<'HTML'
<p>Treine explicar uma função do seu projeto, o caminho de uma requisição, uma falha que investigou e uma decisão que reviu. Leia a documentação antes de adotar uma biblioteca. Se não souber, delimite a hipótese, diga como confirmaria e evite improvisar uma resposta insegura.</p><p>Procure vagas e faixas salariais em fontes atuais da sua região; requisitos mudam por mercado. Não confunda a lista de ferramentas de uma vaga com a obrigação de usar todas no seu primeiro projeto.</p>
HTML],
      ['title'=>'Próximo plano de estudo','body'=> <<<'HTML'
<ol><li>Complete um módulo de cada trilha e faça os quizzes.</li><li>Adapte um dos projetos do portal com uma melhoria própria.</li><li>Registre o que aprendeu e publique instruções reproduzíveis.</li><li>Peça revisão a outra pessoa, corrija e explique o que mudou.</li></ol>
HTML],
    ],
  ],
];
