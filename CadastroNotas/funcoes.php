<?php
// Funções compartilhadas pelas páginas do projeto.

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, "UTF-8");
}

function registrarHistorico($mensagem) {
    if (!isset($_SESSION["historico"]) || !is_array($_SESSION["historico"])) {
        $_SESSION["historico"] = [];
    }

    $_SESSION["historico"][] = [
        "mensagem" => $mensagem,
        "data" => date("d/m/Y H:i:s")
    ];

    // Conserva apenas as cinco operações mais recentes.
    $_SESSION["historico"] = array_slice($_SESSION["historico"], -5);
}
?>
