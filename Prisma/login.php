<?php
// Página de login do Prisma. Ela valida o usuário antes de entrar no sistema.
session_start();
require __DIR__ . '/includes/data.php';
$errors = [];
$data = load_data();
$adminEmail = $data['auth']['email'];
$adminPassword = $data['auth']['password'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

    if (!$email || !$password) {
        $errors[] = 'Digite um e-mail válido e senha.';
    } elseif ($email !== $adminEmail || $password !== $adminPassword) {
        $errors[] = 'Credenciais inválidas. Use o e-mail e senha de administrador.';
    } else {
        $_SESSION['user'] = [
            'name' => 'Administrador Prisma',
            'email' => $adminEmail,
        ];
        // início da contagem da inatividade
        $_SESSION['last_activity'] = time();
        header('Location: index.php');
        exit;
    }
}
$pageTitle = 'Login';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Prisma | Login</title>
  <link rel="stylesheet" href="assets/css/styles.css" />
</head>
<body class="login-body">
  <main class="login-page">
    <div class="login-panel">
      <!-- AVISO DE SESSÃO EXPIRADA -->
      <?php
        if (isset($_GET['aviso']) && $_GET['aviso'] === 'expirado') {
            echo '<div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px; margin-bottom: 20px; border-radius: 4px; font-family: sans-serif; text-align: center;">
                    <strong>Sessão Expirada:</strong> Por motivos de segurança (inatividade), você foi desconectada. Faça login novamente.
                  </div>';
        }
        ?>
        <!-- FIM DO AVISO -->
      <div class="login-brand">
        <div class="logo-mark"><img src="assets/img/logo.svg" alt="Logo Prisma"></div>
        <h1>Prisma</h1>
      </div>
      <p class="login-subtitle">Acesse a plataforma administrativa escolar.</p>

      <?php if (!empty($errors)): ?>
        <div class="alert-box">
          <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="post">
        <label>
          <span>Email</span>
          <input type="email" name="email" placeholder="email@exemplo.com" required />
        </label>
        <label>
          <span>Senha</span>
          <input type="password" name="password" placeholder="Senha" required />
        </label>
        <button type="submit" class="primary-btn">Entrar</button>
      </form>

      <div class="login-footer">
        <a href="#">Esqueci minha senha</a>
      </div>
    </div>
  </main>
</body>
</html>
