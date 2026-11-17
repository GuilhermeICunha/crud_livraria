<?php
/* [P5-03] Carregar livro e categorias
   O que faz: busca as categorias (para o <select>) e, se houver ?id=, busca o livro para edição.
   Comunica com: Categoria::listar() [P2-02]; Livro::buscar() [P3-03]; redirecionar() [P1-08]. */
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../models/Categoria.php';
require_once __DIR__ . '/../../models/Livro.php';

$pdo = conectar();
$categorias = (new Categoria($pdo))->listar();

$id = (int) ($_GET['id'] ?? 0);
$liv = ['id' => 0, 'titulo' => '', 'autor' => '', 'preco' => '', 'estoque' => 0, 'categoria_id' => 0];

if ($id > 0) {
    $encontrado = (new Livro($pdo))->buscar($id);
    if (!$encontrado) {
        redirecionar(BASE_URL . 'views/livros/listar.php', 'Livro não encontrado.', 'erro');
    }
    $liv = $encontrado;
    $liv['preco'] = number_format((float) $liv['preco'], 2, ',', '');
}

$titulo = $id > 0 ? 'Editar livro' : 'Novo livro';
require __DIR__ . '/../layout/header.php';
?>
<?php /* [P5-04] Formulário com <select> de categorias
   O que faz: mostra os campos do livro; o <select> é montado com as categorias do banco e
   marca a categoria atual na edição. Sem categorias, orienta a cadastrar primeiro.
   Comunica com: LivroController ação salvar [P3-08]; relacionamento livros.categoria_id [P1-03]. */ ?>
<h2><?= e($titulo) ?></h2>
<?php if (count($categorias) === 0): ?>
    <p class="vazio">Cadastre uma categoria antes de cadastrar livros.
        <a href="<?= BASE_URL ?>views/categorias/form.php">Nova categoria</a></p>
<?php else: ?>
<form class="cadastro" method="post" action="<?= BASE_URL ?>controllers/LivroController.php?acao=salvar">
    <input type="hidden" name="id" value="<?= (int) $liv['id'] ?>">

    <label for="titulo">Título</label>
    <input type="text" id="titulo" name="titulo" maxlength="150" value="<?= e($liv['titulo']) ?>" required>

    <label for="autor">Autor</label>
    <input type="text" id="autor" name="autor" maxlength="100" value="<?= e($liv['autor']) ?>" required>

    <label for="preco">Preço (R$)</label>
    <input type="text" id="preco" name="preco" value="<?= e($liv['preco']) ?>" required>

    <label for="estoque">Estoque</label>
    <input type="number" id="estoque" name="estoque" min="0" value="<?= (int) $liv['estoque'] ?>" required>

    <label for="categoria_id">Categoria</label>
    <select id="categoria_id" name="categoria_id" required>
        <option value="">Selecione...</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?= (int) $c['id'] ?>" <?= (int) $c['id'] === (int) $liv['categoria_id'] ? 'selected' : '' ?>>
                <?= e($c['nome']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="acoes">
        <button class="botao" type="submit">Salvar</button>
        <a class="botao cinza" href="listar.php">Cancelar</a>
    </div>
</form>
<?php endif; ?>
<?php require __DIR__ . '/../layout/footer.php'; ?>
