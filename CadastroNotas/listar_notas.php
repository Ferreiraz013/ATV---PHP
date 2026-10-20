<?php
session_start();
require_once "funcoes.php";
$registros = $_SESSION["notas_alunos"] ?? [];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas cadastradas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="topo">
        <div class="topo-conteudo">
            <a class="marca" href="index.php">Cadastro de Notas</a>
            <nav>
                <a href="index.php">Cadastrar</a>
                <a class="ativo" href="listar_notas.php">Consultar notas</a>
                <a href="historico.php">Histórico</a>
                <a href="questionario.php">Questionário</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <section class="intro">
            <span class="etiqueta">CONSULTA</span>
            <h1>Notas cadastradas</h1>
            <p>Total de registros: <strong><?= count($registros) ?></strong></p>
            <a class="botao-link" href="index.php">+ Cadastrar outra nota</a>
        </section>

        <section class="painel">
            <?php if (empty($registros)): ?>
                <div class="vazio">
                    <h2>Nenhuma nota cadastrada</h2>
                    <p>Volte ao formulário para adicionar o primeiro registro.</p>
                </div>
            <?php else: ?>
                <div class="tabela-responsiva">
                    <table>
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Disciplina</th>
                                <th>Nota</th>
                                <th>Última alteração</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registros as $registro): ?>
                                <tr>
                                    <td><?= h($registro["aluno"]) ?></td>
                                    <td><?= h($registro["disciplina"]) ?></td>
                                    <td><span class="nota"><?= h(number_format((float)$registro["nota"], 1, ",", ".")) ?></span></td>
                                    <td><?= h($registro["alterado_em"] ?? "Não informada") ?></td>
                                    <td class="acoes">
                                        <a class="acao-editar" href="editar_nota.php?id=<?= urlencode($registro["id"]) ?>">Editar</a>
                                        <form action="excluir_nota.php" method="POST" onsubmit="return confirm('Tem certeza de que deseja excluir esta nota?');">
                                            <input type="hidden" name="id" value="<?= h($registro["id"]) ?>">
                                            <button class="botao-excluir" type="submit">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <footer>Os registros ficam temporariamente na sessão do PHP.</footer>
</body>

</html>