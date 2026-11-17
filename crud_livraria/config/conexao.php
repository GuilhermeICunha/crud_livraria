<?php
/* [P1-05] Constantes de configuração
   O que faz: define host, banco, usuário e senha do MySQL (padrão do XAMPP/LAMPP) e a pasta base do site.
   Comunica com: banco.sql [P1-01] (nome do banco); BASE_URL é usada nas views e controllers
   para montar links e redirecionamentos. */
define('DB_HOST', 'localhost');
define('DB_NOME', 'livraria_crud');
define('DB_USUARIO', 'root');
define('DB_SENHA', '');
define('BASE_URL', '/crud_livraria/');

/* [P1-06] Função conectar()
   O que faz: abre UMA conexão PDO com o MySQL (reaproveitada nas chamadas seguintes).
   Configura erros como exceção e retorno em array associativo.
   Comunica com: é chamada pelos controllers [P2-07, P3-07] e pelas views, que passam
   a conexão para os models [P2-01, P3-01]. */
function conectar(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NOME . ';charset=utf8mb4',
                DB_USUARIO,
                DB_SENHA,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
        }
    }
    return $pdo;
}

/* [P1-07] Função e()
   O que faz: escapa texto para exibir no HTML com segurança (evita injeção de HTML/XSS).
   Comunica com: usada em todas as views (P4 e P5) ao imprimir dados do banco. */
function e($texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/* [P1-08] Função redirecionar()
   O que faz: envia o navegador para outra página, opcionalmente com mensagem (?msg=...&tipo=ok|erro).
   Comunica com: usada pelos controllers [P2-08, P2-09, P3-08, P3-09]; a mensagem é exibida
   pelo layout [P4-02]. */
function redirecionar(string $url, string $msg = '', string $tipo = 'ok'): void
{
    if ($msg !== '') {
        $url .= (strpos($url, '?') === false ? '?' : '&') . 'msg=' . urlencode($msg) . '&tipo=' . $tipo;
    }
    header('Location: ' . $url);
    exit;
}
