<?php
/* [P3-07] Preparação do controller
   O que faz: carrega config e model, cria o objeto Livro, lê ?acao= e bloqueia acessos que não sejam POST.
   Comunica com: config/conexao.php [P1-05..P1-08] e models/Livro.php [P3-01]. */
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Livro.php';

$livro = new Livro(conectar());
$acao = $_GET['acao'] ?? '';
$listar = BASE_URL . 'views/livros/listar.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar($listar);
}

/* [P3-08] Ação salvar (criar ou editar)
   O que faz: lê o formulário, valida cada campo (texto, preço, estoque e categoria) e
   decide: id > 0 atualiza, senão insere. Aceita vírgula no preço (89,90).
   Comunica com: formulário livros/form.php [P5-04] (entrada); Livro::inserir/atualizar
   [P3-04, P3-05]; volta à listagem [P5-02] com mensagem. */
if ($acao === 'salvar') {
    $id = (int) ($_POST['id'] ?? 0);
    $titulo = trim($_POST['titulo'] ?? '');
    $autor = trim($_POST['autor'] ?? '');
    $preco = str_replace(',', '.', trim($_POST['preco'] ?? ''));
    $estoque = trim($_POST['estoque'] ?? '');
    $categoriaId = (int) ($_POST['categoria_id'] ?? 0);
    $form = BASE_URL . 'views/livros/form.php' . ($id > 0 ? '?id=' . $id : '');

    if ($titulo === '' || $autor === '') {
        redirecionar($form, 'Informe o título e o autor.', 'erro');
    }
    if (!is_numeric($preco) || (float) $preco < 0) {
        redirecionar($form, 'Informe um preço válido.', 'erro');
    }
    if (filter_var($estoque, FILTER_VALIDATE_INT) === false || (int) $estoque < 0) {
        redirecionar($form, 'Informe um estoque válido (número inteiro).', 'erro');
    }
    if ($categoriaId <= 0) {
        redirecionar($form, 'Selecione uma categoria.', 'erro');
    }

    try {
        if ($id > 0) {
            $livro->atualizar($id, $titulo, $autor, (float) $preco, (int) $estoque, $categoriaId);
            $msg = 'Livro atualizado com sucesso.';
        } else {
            $livro->inserir($titulo, $autor, (float) $preco, (int) $estoque, $categoriaId);
            $msg = 'Livro cadastrado com sucesso.';
        }
    } catch (PDOException $e) {
        redirecionar($form, 'Erro ao salvar o livro. Verifique a categoria selecionada.', 'erro');
    }
    redirecionar($listar, $msg);
}

/* [P3-09] Ação excluir
   O que faz: apaga o livro pelo id.
   Comunica com: botão Excluir da listagem [P5-02]; Livro::excluir [P3-06]. */
if ($acao === 'excluir') {
    $id = (int) ($_POST['id'] ?? 0);
    try {
        $livro->excluir($id);
        redirecionar($listar, 'Livro excluído com sucesso.');
    } catch (PDOException $e) {
        redirecionar($listar, 'Erro ao excluir o livro.', 'erro');
    }
}

/* [P3-10] Ação desconhecida: volta para a listagem. */
redirecionar($listar);
