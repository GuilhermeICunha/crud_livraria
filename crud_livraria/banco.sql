/* [P1-01] Criação e seleção do banco
   O que faz: cria o banco livraria_crud (se não existir) e o seleciona.
   Comunica com: o nome 'livraria_crud' deve ser igual a DB_NOME em config/conexao.php [P1-05]. */
CREATE DATABASE IF NOT EXISTS livraria_crud CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE livraria_crud;

/* [P1-02] Tabela categorias
   O que faz: guarda as categorias (lado "1" do relacionamento).
   Comunica com: models/Categoria.php [P2-01..P2-06]; é referenciada pela tabela livros [P1-03]. */
CREATE TABLE IF NOT EXISTS categorias (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(100) NOT NULL UNIQUE,
    descricao VARCHAR(255) NULL
) ENGINE=InnoDB;

/* [P1-03] Tabela livros
   O que faz: guarda os livros; categoria_id é chave estrangeira para categorias (lado "N").
   ON DELETE RESTRICT impede apagar uma categoria que ainda tenha livros.
   Comunica com: models/Livro.php [P3-01..P3-06]. */
CREATE TABLE IF NOT EXISTS livros (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    titulo       VARCHAR(150) NOT NULL,
    autor        VARCHAR(100) NOT NULL,
    preco        DECIMAL(10,2) NOT NULL,
    estoque      INT NOT NULL DEFAULT 0,
    categoria_id INT NOT NULL,
    CONSTRAINT fk_livros_categoria FOREIGN KEY (categoria_id)
        REFERENCES categorias(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

/* [P1-04] Dados de exemplo
   O que faz: insere categorias e livros para testar as telas logo após a importação.
   Obs.: importar o script mais de uma vez duplica os livros de exemplo. */
INSERT IGNORE INTO categorias (nome, descricao) VALUES
    ('Programação', 'Livros sobre linguagens e desenvolvimento'),
    ('Banco de Dados', 'Modelagem, SQL e administração'),
    ('Redes', 'Infraestrutura e protocolos');

INSERT INTO livros (titulo, autor, preco, estoque, categoria_id) VALUES
    ('PHP e MySQL', 'Autor Exemplo A', 89.90, 10, (SELECT id FROM categorias WHERE nome='Programação')),
    ('SQL na Prática', 'Autor Exemplo B', 74.50, 5, (SELECT id FROM categorias WHERE nome='Banco de Dados')),
    ('Redes de Computadores', 'Autor Exemplo C', 120.00, 3, (SELECT id FROM categorias WHERE nome='Redes'));
