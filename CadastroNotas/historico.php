<?php
session_start();
require_once "funcoes.php";
$historico = array_reverse($_SESSION["historico"] ?? []);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de operações</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="topo">
        <div class="topo-conteudo">
            <a class="marca" href="index.php">Cadastro de Notas</a>
            <nav>
                <a href="index.php">Cadastrar</a>
                <a href="listar_notas.php">Consultar notas</a>
                <a class="ativo" href="historico.php">Histórico</a>
                <a href="questionario.php">Questionário</a>
            </nav>
        </div>
    </header>
    <main class="container estreito">
        <section class="intro">
            <span class="etiqueta">DESAFIO EXTRA A</span>
            <h1>Histórico de operações</h1>
            <p>Veja as cinco operações mais recentes, começando pela mais nova.</p>
        </section>
        <section class="painel">
            <?php if (empty($historico)): ?>
                <div class="vazio">
                    <h2>Nenhuma operação registrada</h2>
                    <p>Cadastre, edite ou exclua uma nota para começar a preencher o histórico.</p>
                </div>
            <?php else: ?>
                <ol class="lista-historico">
                    <?php foreach ($historico as $operacao): ?>
                        <li>
                            <span class="ponto"></span>
                            <div>
                                <strong><?= h($operacao["mensagem"] ?? "") ?></strong>
                                <small><?= h($operacao["data"] ?? "") ?></small>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            <?php endif; ?>
            <a class="botao-link" href="listar_notas.php">Voltar às notas</a>
        </section>
    </main>
    <footer>O histórico mantém somente as cinco operações mais recentes.</footer>
</body>

</html>