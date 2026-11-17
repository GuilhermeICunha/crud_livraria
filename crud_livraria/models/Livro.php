<?php
/* [P3-01] Classe Livro e construtor
   O que faz: recebe a conexão PDO e a guarda para os métodos.
   Comunica com: PDO vindo de conectar() [P1-06]; usada pelo controller [P3-07] e pelas views [P5-01, P5-03]. */
class Livro
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /* [P3-02] listar() - READ (todos, com JOIN)
       O que faz: retorna os livros já com o NOME da categoria (INNER JOIN), em ordem de título.
       Comunica com: livros/listar.php [P5-01]; usa as duas tabelas de banco.sql [P1-02, P1-03]. */
    public function listar(): array
    {
        $sql = 'SELECT l.id, l.titulo, l.autor, l.preco, l.estoque, c.nome AS categoria
                FROM livros l
                INNER JOIN categorias c ON c.id = l.categoria_id
                ORDER BY l.titulo';
        return $this->pdo->query($sql)->fetchAll();
    }

    /* [P3-03] buscar() - READ (um)
       O que faz: retorna um livro pelo id (ou false).
       Comunica com: livros/form.php [P5-03] para preencher a edição. */
    public function buscar(int $id)
    {
        $st = $this->pdo->prepare(
            'SELECT id, titulo, autor, preco, estoque, categoria_id FROM livros WHERE id = ?'
        );
        $st->execute([$id]);
        return $st->fetch();
    }

    /* [P3-04] inserir() - CREATE
       O que faz: grava um novo livro, incluindo a categoria escolhida (categoria_id).
       Comunica com: LivroController, ação salvar sem id [P3-08]. */
    public function inserir(string $titulo, string $autor, float $preco, int $estoque, int $categoriaId): void
    {
        $st = $this->pdo->prepare(
            'INSERT INTO livros (titulo, autor, preco, estoque, categoria_id) VALUES (?, ?, ?, ?, ?)'
        );
        $st->execute([$titulo, $autor, $preco, $estoque, $categoriaId]);
    }

    /* [P3-05] atualizar() - UPDATE
       O que faz: altera todos os campos de um livro existente.
       Comunica com: LivroController, ação salvar com id [P3-08]. */
    public function atualizar(int $id, string $titulo, string $autor, float $preco, int $estoque, int $categoriaId): void
    {
        $st = $this->pdo->prepare(
            'UPDATE livros SET titulo = ?, autor = ?, preco = ?, estoque = ?, categoria_id = ? WHERE id = ?'
        );
        $st->execute([$titulo, $autor, $preco, $estoque, $categoriaId, $id]);
    }

    /* [P3-06] excluir() - DELETE
       O que faz: apaga um livro pelo id. Comunica com: LivroController, ação excluir [P3-09]. */
    public function excluir(int $id): void
    {
        $st = $this->pdo->prepare('DELETE FROM livros WHERE id = ?');
        $st->execute([$id]);
    }
}
