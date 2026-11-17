<?php
/* [P2-07] Preparação do controller
   O que faz: carrega config e model, cria o objeto Categoria, lê a ação da URL (?acao=)
   e bloqueia acessos que não sejam POST.
   Comunica com: config/conexao.php [P1-05..P1-08] e models/Categoria.php [P2-01]. */
require_once __DIR__ . '/../config/conexao.php';
require_once __DIR__ . '/../models/Categoria.php';

$categoria = new Categoria(conectar());
$acao = $_GET['acao'] ?? '';
$listar = BASE_URL . 'views/categorias/listar.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirecionar($listar);
}

/* [P2-08] Ação salvar (criar ou editar)
   O que faz: lê o formulário, valida o nome e decide: com id > 0 atualiza, sem id insere.
   Trata nome duplicado (erro MySQL 1062 do UNIQUE [P1-02]).
   Comunica com: formulário categorias/form.php [P4-09] (entrada); Categoria::inserir/atualizar
   [P2-04, P2-05]; volta para a listagem [P4-07] com mensagem. */
if ($acao === 'salvar') {
    $id = (int) ($_POST['id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $form = BASE_URL . 'views/categorias/form.php' . ($id > 0 ? '?id=' . $id : '');

    if ($nome === '') {
        redirecionar($form, 'Informe o nome da categoria.', 'erro');
    }

    try {
        if ($id > 0) {
            $categoria->atualizar($id, $nome, $descricao);
            $msg = 'Categoria atualizada com sucesso.';
        } else {
            $categoria->inserir($nome, $descricao);
            $msg = 'Categoria cadastrada com sucesso.';
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            redirecionar($form, 'Já existe uma categoria com esse nome.', 'erro');
        }
        redirecionar($form, 'Erro ao salvar a categoria.', 'erro');
    }
    redirecionar($listar, $msg);
}

/* [P2-09] Ação excluir
   O que faz: apaga a categoria pelo id. Se ela tiver livros, o MySQL bloqueia (erro 1451
   da FK [P1-03]) e o usuário recebe uma mensagem clara.
   Comunica com: botão Excluir da listagem [P4-07]; Categoria::excluir [P2-06]. */
if ($acao === 'excluir') {
    $id = (int) ($_POST['id'] ?? 0);
    try {
        $categoria->excluir($id);
        redirecionar($listar, 'Categoria excluída com sucesso.');
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1451) {
            redirecionar($listar, 'Não é possível excluir: existem livros nesta categoria.', 'erro');
        }
        redirecionar($listar, 'Erro ao excluir a categoria.', 'erro');
    }
}

/* [P2-10] Ação desconhecida
   O que faz: qualquer outra ação volta para a listagem. */
redirecionar($listar);
