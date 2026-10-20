<?php
session_start();
require_once "funcoes.php";

$id = $_POST["id"] ?? "";
$encontrado = false;

foreach ($_SESSION["notas_alunos"] ?? [] as $indice => $registro) {
    if (($registro["id"] ?? "") === $id) {
        $aluno = $registro["aluno"] ?? "Aluno sem nome";
        $disciplina = $registro["disciplina"] ?? "Disciplina sem nome";
        unset($_SESSION["notas_alunos"][$indice]);
        // Reorganiza os índices numéricos após a exclusão.
        $_SESSION["notas_alunos"] = array_values($_SESSION["notas_alunos"]);
        registrarHistorico("Cadastro excluído: " . $aluno . " (" . $disciplina . ").");
        $encontrado = true;
        break;
    }
}

header("Location: listar_notas.php");
exit;
?>
