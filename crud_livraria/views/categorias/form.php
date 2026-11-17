<?php
/* [P4-08] Modo novo ou edição
   O que faz: se a URL tem ?id=, busca a categoria para preencher o formulário (edição);
   senão usa valores vazios (novo). Se o id não existe, volta à listagem com erro.
   Comunica com: Categoria::buscar() [P2-03]; redirecionar() [P1-08]; header.php [P4-01]. */
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../models/Categoria.php';

$id = (int) ($_GET['id'] ?? 0);
$cat = ['id' => 0, 'nome' => '', 'descricao' => ''];

if ($id > 0) {
    $encontrada = (new Categoria(conectar()))->buscar($id);
    if (!$encontrada) {
        redirecionar(BASE_URL . 'views/categorias/listar.php', 'Categoria não encontrada.', 'erro');
    }
    $cat = $encontrada;
}

$titulo = $id > 0 ? 'Editar categoria' : 'Nova categoria';
require __DIR__ . '/../layout/header.php';
?>
<?php /* [P4-09] Formulário
   O que faz: envia nome e descrição (e o id oculto) por POST.
   Comunica com: CategoriaController ação salvar [P2-08]; botão Cancelar volta a listar.php [P4-06]. */ ?>
<h2><?= e($titulo) ?></h2>
<form class="cadastro" method="post" action="<?= BASE_URL ?>controllers/CategoriaController.php?acao=salvar">
    <input type="hidden" name="id" value="<?= (int) $cat['id'] ?>">

    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" maxlength="100" value="<?= e($cat['nome']) ?>" required>

    <label for="descricao">Descrição</label>
    <input type="text" id="descricao" name="descricao" maxlength="255" value="<?= e($cat['descricao']) ?>">

    <div class="acoes">
        <button class="botao" type="submit">Salvar</button>
        <a class="botao cinza" href="listar.php">Cancelar</a>
    </div>
</form>
<?php require __DIR__ . '/../layout/footer.php'; ?>
