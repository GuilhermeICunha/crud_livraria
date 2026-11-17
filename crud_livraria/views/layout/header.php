<?php
require_once __DIR__ . '/../../config/conexao.php';
$titulo = $titulo ?? 'Livraria';

/* [P4-01] Cabeçalho HTML e menu
   O que faz: abre <html>, carrega o CSS externo e mostra o menu de navegação.
   Comunica com: css/estilo.css [P4-04]; BASE_URL de config [P1-05]; incluído no topo de todas as views. */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo) ?> - Livraria CRUD</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/estilo.css">
</head>
<body>
<header class="topo">
    <h1>Livraria CRUD</h1>
    <nav>
        <a href="<?= BASE_URL ?>index.php">Início</a>
        <a href="<?= BASE_URL ?>views/categorias/listar.php">Categorias</a>
        <a href="<?= BASE_URL ?>views/livros/listar.php">Livros</a>
    </nav>
</header>
<main class="conteudo">
<?php
/* [P4-02] Mensagens de retorno
   O que faz: se a URL tiver ?msg=, mostra um aviso verde (ok) ou vermelho (erro).
   Comunica com: redirecionar() [P1-08], chamada pelos controllers [P2-08, P2-09, P3-08, P3-09]. */
if (isset($_GET['msg'])): ?>
    <div class="alerta <?= ($_GET['tipo'] ?? 'ok') === 'erro' ? 'erro' : 'ok' ?>"><?= e($_GET['msg']) ?></div>
<?php endif; ?>
