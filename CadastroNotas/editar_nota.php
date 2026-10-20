<?php
session_start();
require_once "funcoes.php";

$id = $_GET["id"] ?? "";
$encontrado = null;

foreach ($_SESSION["notas_alunos"] ?? [] as $registro) {
    if (($registro["id"] ?? "") === $id) {
        $encontrado = $registro;
        break;
    }
}

if ($encontrado === null) {
    http_response_code(404);
    exit('Registro não encontrado. <a href="listar_notas.php">Voltar à listagem</a>.');
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar nota</title>
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
    <main class="container estreito">
        <section class="intro">
            <span class="etiqueta">EDIÇÃO DE REGISTRO</span>
            <h1>Editar nota do aluno</h1>
            <p>Altere os campos necessários e salve as alterações.</p>
        </section>
        <section class="painel">
            <form action="atualizar_nota.php" method="POST">
                <input type="hidden" name="id" value="<?= h($encontrado["id"]) ?>">

                <label for="aluno">Nome do aluno</label>
                <input type="text" id="aluno" name="aluno" maxlength="100" value="<?= h($encontrado["aluno"]) ?>" required>

                <label for="disciplina">Disciplina</label>
                <input type="text" id="disciplina" name="disciplina" maxlength="100" value="<?= h($encontrado["disciplina"]) ?>" required>

                <label for="nota">Nota (0 a 10)</label>
                <input type="number" id="nota" name="nota" min="0" max="10" step="0.1" value="<?= h($encontrado["nota"]) ?>" required>

                <button type="submit">Salvar alterações</button>
                <a class="link-secundario" href="listar_notas.php">Cancelar</a>
            </form>
        </section>
    </main>
    <footer>A data da última alteração é atualizada ao salvar.</footer>
</body>

</html>