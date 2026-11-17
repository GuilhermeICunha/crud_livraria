<?php
/* [P2-01] Classe Categoria e construtor
   O que faz: recebe a conexão PDO e a guarda para os métodos usarem.
   Comunica com: recebe o PDO de conectar() [P1-06], chamado pelo controller [P2-07] e pelas views [P4-06, P4-08, P5-03]. */
class Categoria
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /* [P2-02] listar() - READ (todas)
       O que faz: retorna todas as categorias em ordem alfabética.
       Comunica com: views categorias/listar.php [P4-06] e livros/form.php [P5-03] (preenche o <select>). */
    public function listar(): array
    {
        return $this->pdo->query('SELECT id, nome, descricao FROM categorias ORDER BY nome')->fetchAll();
    }

    /* [P2-03] buscar() - READ (uma)
       O que faz: retorna uma categoria pelo id (ou false se não existir).
       Comunica com: categorias/form.php [P4-08] para preencher o formulário de edição. */
    public function buscar(int $id)
    {
        $st = $this->pdo->prepare('SELECT id, nome, descricao FROM categorias WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch();
    }

    /* [P2-04] inserir() - CREATE
       O que faz: grava uma nova categoria usando prepared statement.
       Comunica com: CategoriaController, ação salvar sem id [P2-08]. */
    public function inserir(string $nome, string $descricao): void
    {
        $st = $this->pdo->prepare('INSERT INTO categorias (nome, descricao) VALUES (?, ?)');
        $st->execute([$nome, $descricao]);
    }

    /* [P2-05] atualizar() - UPDATE
       O que faz: altera nome e descrição de uma categoria existente.
       Comunica com: CategoriaController, ação salvar com id [P2-08]. */
    public function atualizar(int $id, string $nome, string $descricao): void
    {
        $st = $this->pdo->prepare('UPDATE categorias SET nome = ?, descricao = ? WHERE id = ?');
        $st->execute([$nome, $descricao, $id]);
    }

    /* [P2-06] excluir() - DELETE
       O que faz: apaga uma categoria. Se houver livros ligados a ela, o MySQL lança
       exceção (FK RESTRICT [P1-03]) que o controller trata [P2-09]. */
    public function excluir(int $id): void
    {
        $st = $this->pdo->prepare('DELETE FROM categorias WHERE id = ?');
        $st->execute([$id]);
    }
}
