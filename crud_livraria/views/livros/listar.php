<?php
/* [P5-01] Carregamento dos dados
   O que faz: conecta ao banco, pede ao model a lista de livros (já com JOIN) e abre o layout.
   Comunica com: conectar() [P1-06]; Livro::listar() [P3-02]; header.php [P4-01]. */
require_once __DIR__ . '/../../config/conexao.php';
require_once __DIR__ . '/../../models/Livro.php';

$livros = (new Livro(conectar()))->listar();
$titulo = 'Livros';
require __DIR__ . '/../layout/header.php';
?>
<?php /* [P5-02] Tabela e ações
   O que faz: mostra título, autor, categoria, preço (formato R$) e estoque. Editar abre form.php?id=...;
   Excluir envia POST com confirmação.
   Comunica com: form.php [P5-04]; LivroController ação excluir [P3-09]. */ ?>
<div class="barra">
    <h2>Livros</h2>
    <a class="botao" href="form.php">Novo livro</a>
</div>
<?php if (count($livros) === 0): ?>
    <p class="vazio">Nenhum livro cadastrado.</p>
<?php else: ?>
    <table>
        <thead><tr><th>Título</th><th>Autor</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr></thead>
        <tbody>
        <?php foreach ($livros as $l): ?>
            <tr>
                <td><?= e($l['titulo']) ?></td>
                <td><?= e($l['autor']) ?></td>
                <td><?= e($l['categoria']) ?></td>
                <td>R$ <?= number_format((float) $l['preco'], 2, ',', '.') ?></td>
                <td><?= (int) $l['estoque'] ?></td>
                <td>
                    <a class="botao pequeno" href="form.php?id=<?= (int) $l['id'] ?>">Editar</a>
                    <form class="inline" method="post"
                          action="<?= BASE_URL ?>controllers/LivroController.php?acao=excluir"
                          onsubmit="return confirm('Excluir este livro?');">
                        <input type="hidden" name="id" value="<?= (int) $l['id'] ?>">
                        <button class="botao pequeno perigo" type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php require __DIR__ . '/../layout/footer.php'; ?>
