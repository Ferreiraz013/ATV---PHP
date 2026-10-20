<?php
session_start();
require_once "funcoes.php";

function normalizarResposta($valor) {
    if (!is_array($valor)) {
        return is_scalar($valor) ? (string)$valor : "";
    }

    $partes = [];
    array_walk_recursive($valor, function ($item) use (&$partes) {
        if (is_scalar($item)) {
            $partes[] = (string)$item;
        }
    });

    return implode(" ", $partes);
}

$perguntas = [
    [
        "pergunta" => "O que é uma sessão em PHP?",
        "resposta" => 'Uma sessão permite manter informações de um usuário disponíveis entre diferentes páginas durante a navegação. Em PHP, os dados são acessados por meio de $_SESSION.'
    ],
    [
        "pergunta" => "Por que utilizamos isset() antes de criar o array de notas dos alunos?",
        "resposta" => "Porque isset() verifica se a variável de sessão já existe. Assim, o array vazio só é criado quando necessário, sem apagar os registros já guardados."
    ],
    [
        "pergunta" => "Qual é a diferença entre $_POST e $_SESSION?",
        "resposta" => '$_POST recebe dados enviados por um formulário usando o método POST. $_SESSION mantém dados disponíveis entre páginas enquanto a sessão estiver ativa.'
    ],
    [
        "pergunta" => "Para que serve o comando foreach na listagem dos registros?",
        "resposta" => "foreach percorre os elementos de um array, permitindo exibir os dados de cada registro."
    ],
    [
        "pergunta" => "Qual é a função de count() no arquivo listar_notas.php?",
        "resposta" => "count() conta os elementos do array e permite mostrar o total de registros cadastrados."
    ],
    [
        "pergunta" => "Como o sistema identifica qual registro deve ser editado ou excluído?",
        "resposta" => "Por meio de um identificador único (id), que diferencia um registro dos demais, mesmo quando os nomes dos alunos são iguais."
    ],
    [
        "pergunta" => "Qual é a diferença entre unset() e session_destroy()?",
        "resposta" => "unset() pode remover um elemento específico de um array. session_destroy() encerra a sessão inteira."
    ],
    [
        "pergunta" => "Qual é a importância de utilizar sessões ($_SESSION) neste projeto? O que aconteceria com os registros se o sistema utilizasse apenas variáveis comuns do PHP?",
        "resposta" => 'A sessão mantém os registros disponíveis entre páginas. Variáveis comuns não são preservadas automaticamente entre requisições, então os dados não continuariam disponíveis da mesma maneira.'
    ],
    [
        "pergunta" => "Por que os dados cadastrados neste projeto podem ser perdidos? O que você mudaria para que as notas continuassem salvas mesmo depois de fechar o navegador?",
        "resposta" => "Os dados são temporários e podem desaparecer quando a sessão expirar ou for encerrada. Para mantê-los permanentemente, eu usaria um banco de dados, como MySQL."
    ],
    [
        "pergunta" => "Como o recurso de edição ajuda a corrigir uma nota cadastrada incorretamente? Por que é importante permitir a alteração sem precisar excluir e cadastrar tudo novamente?",
        "resposta" => "A edição permite corrigir um registro existente sem excluí-lo, facilitando a correção e preservando o identificador do registro."
    ],
    [
        "pergunta" => "Por que cada registro precisa ter um identificador único? O que poderia acontecer se o sistema tentasse editar ou excluir um aluno utilizando apenas o nome dele?",
        "resposta" => "O identificador único permite localizar o registro certo. Usar apenas o nome poderia causar confusão entre alunos com nomes iguais e levar à alteração ou exclusão do registro errado."
    ],
    [
        "pergunta" => "Qual é a importância de validar a nota antes de armazená-la? O que poderia acontecer se o sistema aceitasse valores negativos, notas acima de 10 ou campos vazios?",
        "resposta" => "A validação impede dados fora das regras do sistema. Sem ela, poderiam ser armazenadas notas inválidas ou informações incompletas."
    ],
    [
        "pergunta" => "Por que o histórico deve armazenar somente as cinco operações mais recentes? Em quais situações seria interessante guardar um histórico maior ou completo?",
        "resposta" => "O limite atende ao desafio e deixa o histórico simples. Em sistemas reais, um histórico maior pode ser útil para auditorias, acompanhamento e investigação de erros."
    ],
    [
        "pergunta" => "Como o histórico de operações pode ajudar a identificar erros ou acompanhar as alterações realizadas no sistema? Quais informações deveriam ser registradas para tornar esse recurso mais útil?",
        "resposta" => "Ele permite ver quais operações aconteceram e quando. Seria útil registrar data e hora, tipo de operação, identificador do registro e usuário responsável, quando houver login."
    ],
    [
        "pergunta" => "Como o uso de sessões e a ausência de um banco de dados podem limitar o compartilhamento das informações entre professores que utilizam computadores diferentes?",
        "resposta" => "Os dados ficam associados à sessão e não são armazenados em um repositório compartilhado. Por isso, professores em computadores diferentes não consultam automaticamente os mesmos registros."
    ],
    [
        "pergunta" => "Quais cuidados de segurança devem ser tomados ao exibir os nomes dos alunos e suas notas em uma página PHP? Por que devemos utilizar recursos como htmlspecialchars()?",
        "resposta" => "É importante validar os dados e escapar os textos ao exibi-los. htmlspecialchars() converte caracteres especiais para que sejam tratados como texto, ajudando a impedir a interpretação de conteúdo digitado como HTML."
    ],
    [
        "pergunta" => "Se você fosse responsável por transformar este projeto em um sistema utilizado por uma escola real, quais três melhorias implementaria e por quê?",
        "resposta" => "1. Banco de dados MySQL, para armazenar os dados permanentemente. 2. Login e permissões, para restringir o acesso. 3. Relatórios e histórico completo, para acompanhar o desempenho e as alterações."
    ]
];

if (!isset($_SESSION['respostas_questionario'])) {
    $_SESSION['respostas_questionario'] = [];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($perguntas as $indice => $item) {
        $resp = $_POST["resposta"][$indice] ?? "";
        $respostaUsuario = trim(normalizarResposta($resp));
        $_SESSION["respostas_questionario"][$indice] = $respostaUsuario;
    }
    $_SESSION["questionario_salvo"] = true;
    header("Location: questionario.php?salvo=1");
    exit;
}

$respostasUsuario = $_SESSION["respostas_questionario"] ?? [];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionário - Cadastro de Notas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="topo">
        <div class="topo-conteudo">
            <a class="marca" href="index.php">Cadastro de Notas</a>
            <nav>
                <a href="index.php">Cadastrar</a>
                <a href="listar_notas.php">Consultar notas</a>
                <a href="historico.php">Histórico</a>
                <a class="ativo" href="questionario.php">Questionário</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <section class="intro">
            <span class="etiqueta">ATIVIDADE TEÓRICA</span>
            <h1>Questionário sobre PHP e sessões</h1>
            <p>Responda às 17 perguntas relacionadas ao funcionamento do projeto. Suas respostas ficam guardadas na sessão.</p>
        </section>

        <?php if (isset($_GET["salvo"])): ?>
            <div class="aviso-sucesso">Respostas salvas nesta sessão.</div>
        <?php endif; ?>

        <section class="painel">
            <div class="linha-titulo">
                <div>
                    <h2>Questões</h2>
                    <p class="texto-ajuda">Escreva suas respostas nos campos abaixo.</p>
                </div>
                <button type="button" class="botao-claro" id="alternarRespostas">Mostrar respostas de referência</button>
            </div>

            <form action="questionario.php" method="POST">
                <?php foreach ($perguntas as $indice => $item): ?>
                    <?php 
                        $valorResposta = normalizarResposta($respostasUsuario[$indice] ?? "");
                    ?>
                    <article class="questao">
                        <label for="resposta<?= $indice ?>"><strong><?= ($indice + 1) ?>. <?= h($item["pergunta"]) ?></strong></label>
                        <textarea id="resposta<?= $indice ?>" name="resposta[<?= $indice ?>]" rows="3" placeholder="Digite sua resposta..."><?= h($valorResposta) ?></textarea>
                        <div class="resposta-referencia" hidden>
                            <strong>Resposta de referência:</strong>
                            <p><?= h($item["resposta"]) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
                <button type="submit">Salvar respostas</button>
            </form>
            <p class="texto-ajuda">As respostas são temporárias e ficam associadas à sessão do PHP.</p>
        </section>
    </main>
    <footer>Questionário integrado ao projeto Cadastro de Notas.</footer>
    <script>
        const botao = document.getElementById("alternarRespostas");
        const referencias = document.querySelectorAll(".resposta-referencia");

        botao.addEventListener("click", function() {
            const vaiMostrar = referencias.length > 0 && referencias[0].hidden;
            referencias.forEach(function(item) {
                item.hidden = !vaiMostrar;
            });
            botao.textContent = vaiMostrar ?
                "Ocultar respostas de referência" :
                "Mostrar respostas de referência";
        });
    </script>
</body>

</html>