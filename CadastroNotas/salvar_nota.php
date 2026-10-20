<?php
session_start();
require_once "funcoes.php";

if (!isset($_SESSION["notas_alunos"])) {
    $_SESSION["notas_alunos"] = [];
}

$aluno = trim($_POST["aluno"] ?? "");
$disciplina = trim($_POST["disciplina"] ?? "");
$nota = $_POST["nota"] ?? "";

if (
    $aluno === "" ||
    $disciplina === "" ||
    $nota === "" ||
    !is_numeric($nota) ||
    (float)$nota < 0 ||
    (float)$nota > 10
) {
    exit('Dados inválidos. <a href="index.php">Voltar ao formulário</a>.');
}

$_SESSION["notas_alunos"][] = [
    "id" => uniqid("nota_", true),
    "aluno" => $aluno,
    "disciplina" => $disciplina,
    "nota" => (float)$nota,
    "alterado_em" => date("d/m/Y H:i:s")
];

registrarHistorico("Nota cadastrada para o aluno " . $aluno . " (" . $disciplina . ").");

header("Location: listar_notas.php");
exit;
?>
