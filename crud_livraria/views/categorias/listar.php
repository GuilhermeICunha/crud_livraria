<?php
/* [P4-06] Carregamento dos dados
   O que faz: conecta ao banco, pede ao model a lista de categorias e abre o layout.
   Comunica com: conectar() [P1-06]; Categoria::listar() [P2-02]; header.php [P4-01]. */
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../models/Categoria.php';

$categorias = (new Categoria(conectar()))->listar();
$titulo = 'Categorias';
require __DIR__ . '/../layout/header.php';
?>
<?php /* [P4-07] Tabela e ações
   O que faz: mostra a tabela (ou aviso se vazia). Editar abre form.php?id=...; Excluir envia POST
   com confirmação em JavaScript.
   Comunica com: form.php [P4-09]; CategoriaController ação excluir [P2-09]. */ ?>
<div class="barra">
    <h2>Categorias</h2>
    <a class="botao" href="form.php">Nova categoria</a>
</div>
<?php if (count($categorias) === 0): ?>
    <p class="vazio">Nenhuma categoria cadastrada.</p>
<?php else: ?>
    <table>
        <thead><tr><th>Nome</th><th>Descrição</th><th>Ações</th></tr></thead>
        <tbody>
        <?php foreach ($categorias as $c): ?>
            <tr>
                <td><?= e($c['nome']) ?></td>
                <td><?= e($c['descricao']) ?></td>
                <td>
                    <a class="botao pequeno" href="form.php?id=<?= (int) $c['id'] ?>">Editar</a>
                    <form class="inline" method="post"
                          action="<?= BASE_URL ?>controllers/CategoriaController.php?acao=excluir"
                          onsubmit="return confirm('Excluir esta categoria?');">
                        <input type="hidden" name="id" value="<?= (int) $c['id'] ?>">
                        <button class="botao pequeno perigo" type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php require __DIR__ . '/../layout/footer.php'; ?>
