<?php
/* [P4-05] Página inicial
   O que faz: mostra dois cartões com links para as listagens.
   Comunica com: layout header/footer [P4-01, P4-03]; links para views/categorias/listar.php [P4-06]
   e views/livros/listar.php [P5-01]. */
$titulo = 'Início';
require __DIR__ . '/views/layout/header.php';
?>
<h2>Bem-vindo</h2>
<p>Sistema de cadastro de livros organizados por categoria.</p>
<div class="cartoes">
    <div class="cartao">
        <h3>Categorias</h3>
        <p>Cadastre as categorias dos livros.</p>
        <a class="botao" href="<?= BASE_URL ?>views/categorias/listar.php">Abrir categorias</a>
    </div>
    <div class="cartao">
        <h3>Livros</h3>
        <p>Cadastre os livros e vincule a uma categoria.</p>
        <a class="botao" href="<?= BASE_URL ?>views/livros/listar.php">Abrir livros</a>
    </div>
</div>
<?php require __DIR__ . '/views/layout/footer.php'; ?>
