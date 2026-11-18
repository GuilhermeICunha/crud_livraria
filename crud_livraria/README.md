# Livraria CRUD (PHP + MySQL)

Trabalho Prático 2 – Parte 2 | Linguagem e Técnicas de Programação | Prof. Flores | ESOFT-2

Sistema CRUD com duas entidades relacionadas: **Categorias** (1) → **Livros** (N).

## Informações da Disciplina

- **Curso:** Engenharia de Software
- **Disciplina:** Linguagem e Técnicas de Programação
- **Professor:** José Carlos Domingues Flores
- **Turma:** ESOFT2

## Componentes do Grupo

| RA         | Nome                              |
|------------|-----------------------------------|
| 26010633-2 | Enzo Gabriel Vilas Boas Alves     |
| 26013861-2 | Filipe Przyvitoski Kasenoh        |
| 26015309-2 | Guilherme Mascarello Cunha        |
| 26014605-2 | Kaik da Silva Nascimento          |
| 26014360-2 | Willian Tadeu Ribeiro             |

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
