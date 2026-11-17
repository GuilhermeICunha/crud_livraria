# Livraria CRUD (PHP + MySQL)

Trabalho Prático 2 – Parte 2 | Linguagem e Técnicas de Programação | Prof. Flores | ESOFT-2

Sistema CRUD com duas entidades relacionadas: **Categorias** (1) → **Livros** (N).

## Como instalar (XAMPP/LAMPP)
1. Copie a pasta `crud_livraria` para o `htdocs` (no LAMPP/Linux: `/opt/lampp/htdocs/`).
2. Inicie Apache e MySQL.
3. No phpMyAdmin (http://localhost/phpmyadmin) vá em **Importar**, escolha `banco.sql` e execute.
4. Acesse http://localhost/crud_livraria/
5. Se o usuário/senha do MySQL forem diferentes, ajuste `config/conexao.php` [P1-05].

## Estrutura
```
crud_livraria/
├── banco.sql                      (P1) script do banco
├── config/conexao.php             (P1) configuração, conexão, funções auxiliares
├── models/Categoria.php           (P2) SQL de categorias
├── controllers/CategoriaController.php (P2) validação e ações de categorias
├── models/Livro.php               (P3) SQL de livros (com JOIN)
├── controllers/LivroController.php     (P3) validação e ações de livros
├── views/layout/header.php        (P4) topo, menu e mensagens
├── views/layout/footer.php        (P4) rodapé
├── css/estilo.css                 (P4) estilos
├── index.php                      (P4) página inicial
├── views/categorias/listar.php    (P4) listagem de categorias
├── views/categorias/form.php      (P4) formulário de categorias
├── views/livros/listar.php        (P5) listagem de livros
└── views/livros/form.php          (P5) formulário de livros
```

## Como ler os identificadores
Cada bloco de código tem um comentário `[Px-yy]`: **x** = parte de estudo (1 a 5), **yy** = número do bloco.
Os comentários dizem "O que faz" e "Comunica com" (outros blocos, pelo ID).

## Fluxo geral (todo CRUD segue o mesmo caminho)
- **Ler (R):** navegador → View → Model (SELECT) → View mostra a tabela.
- **Criar/Editar (C/U):** View (formulário) → POST → Controller (valida) → Model (INSERT/UPDATE) → redireciona para a listagem com mensagem.
- **Excluir (D):** botão na listagem → POST → Controller → Model (DELETE) → redireciona com mensagem.
