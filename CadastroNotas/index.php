<?php
session_start();

// Cria os arrays apenas na primeira visita.
if (!isset($_SESSION["notas_alunos"])) {
    $_SESSION["notas_alunos"] = [];
}
if (!isset($_SESSION["historico"])) {
    $_SESSION["historico"] = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Notas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="topo">
        <div class="topo-conteudo">
            <a class="marca" href="index.php">Cadastro de Notas</a>
            <nav>
                <a class="ativo" href="index.php">Cadastrar</a>
                <a href="listar_notas.php">Consultar notas</a>
                <a href="historico.php">Histórico</a>
                <a href="questionario.php">Questionário</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="intro">
            <span class="etiqueta">ATIVIDADE PRÁTICA • PHP</span>
            <h1>Cadastro de Notas dos Alunos</h1>
            <p>Cadastre alunos, informe as disciplinas e acompanhe as notas em um só lugar.</p>
        </section>

        <section class="painel">
            <h2>Nova nota</h2>
            <p class="texto-ajuda">Preencha os campos abaixo. A nota deve ficar entre 0 e 10.</p>
            <form action="salvar_nota.php" method="POST">
                <label for="aluno">Nome do aluno</label>
                <input type="text" id="aluno" name="aluno" maxlength="100" required>

                <label for="disciplina">Disciplina</label>
                <input type="text" id="disciplina" name="disciplina" maxlength="100" required>

                <label for="nota">Nota (0 a 10)</label>
                <input type="number" id="nota" name="nota" min="0" max="10" step="0.1" required>

                <button type="submit">Cadastrar nota</button>
            </form>
        </section>

        <section class="atalhos">
            <a class="atalho" href="listar_notas.php">
                <strong>Consultar registros</strong>
                <span>Visualize, edite ou exclua notas.</span>
            </a>
            <a class="atalho" href="historico.php">
                <strong>Histórico de operações</strong>
                <span>Confira as cinco operações mais recentes.</span>
            </a>
            <a class="atalho" href="questionario.php">
                <strong>Questionário da atividade</strong>
                <span>Leia e responda às questões do PDF.</span>
            </a>
        </section>
    </main>
    <footer>Projeto de prática em PHP • Os dados são guardados temporariamente na sessão.</footer>
</body>

</html>