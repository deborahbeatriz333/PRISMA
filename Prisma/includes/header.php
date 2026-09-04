<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$timeout_duration = 900; // 15 minutos

if (isset($_SESSION['last_activity'])) {
    $elapsed_time = time() - $_SESSION['last_activity'];

    if ($elapsed_time > $timeout_duration) {
        session_unset();     
        session_destroy();   
        // Redireciona para o login com um parâmetro de aviso
        header("Location: ../login.php?aviso=expirado"); 
        exit();
    }
}
// agora deixamos o login/sessão inicializar a contagem

$_SESSION['last_activity'] = time();

// Atualiza o tempo da última atividade para o momento atual
$_SESSION['last_activity'] = time(); 

// Busca os dados do sistema para mostrar mensagens, notificações e informações do usuário.
require_once __DIR__ . '/data.php';
$data = load_data();
$messageCount = count($data['messages'] ?? []);
$notifications = array_filter($data['notifications'] ?? [], function ($notification) {
    return empty($notification['read']);
});
$notificationCount = count($notifications);
$searchQuery = htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8');
$user = $_SESSION['user'] ?? [
    'name' => $data['profile']['name'] ?? 'Usuário',
    'email' => $data['profile']['email'] ?? '',
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Prisma | <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="stylesheet" href="assets/css/styles.css?v=<?= filemtime(__DIR__ . '/../assets/css/styles.css') ?>" />
  <script>
    // Tempo limite em milissegundos (15 minutos = 900.000 ms)
    const tempoLimite = 900000; 

    // Inicia um temporizador decrescente
    setTimeout(function() {
        // Redireciona para a tela de login avisando que expirou
        window.location.href = '/Prisma/login.php?aviso=expirado';
    }, tempoLimite);
</script>
</head>
<body>
  <!-- Cabeçalho principal da aplicação, com busca e ícones de alerta. -->
  <header class="topbar">
    <div class="topbar-brand">
      <img src="assets/img/logo.svg" alt="Prisma" />
    </div>
    <form class="search-bar" method="get" action="index.php">
      <input type="hidden" name="page" value="alunos" />
      <button type="submit" class="search-submit" aria-label="Buscar">
        🔍
      </button>
      <input type="search" name="search" placeholder="Buscar aluno, turma ou atividade..." value="<?= $searchQuery ?>" />
    </form>
    <div class="topbar-actions">
      <button class="icon-btn toggle-panel" data-panel="messages" title="Mensagens">
        ✉️
        <?php if ($messageCount > 0): ?>
          <span class="badge-count"><?= $messageCount ?></span>
        <?php endif; ?>
      </button>
      <button class="icon-btn toggle-panel" data-panel="notifications" data-mark-read="1" title="Notificações">
        🔔
        <?php if ($notificationCount > 0): ?>
          <span class="badge-count"><?= $notificationCount ?></span>
        <?php endif; ?>
      </button>
      <div class="user-chip">
        <span class="user-initials"><?= strtoupper(substr($user['name'], 0, 1)) ?></span>
        <div>
          <strong><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></strong>
          <small>Coordenação</small>
        </div>
      </div>
    </div>
  </header>
  <div class="panel-dropdown panel-messages topbar-dropdown" hidden>
    <div class="panel-header">Mensagens</div>
    <?php if (!empty($data['messages'])): ?>
      <?php foreach ($data['messages'] as $message): ?>
        <div class="panel-item">
          <strong><?= htmlspecialchars($message['title'], ENT_QUOTES, 'UTF-8') ?></strong>
          <p><?= htmlspecialchars($message['text'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="panel-empty">Nenhuma mensagem nova.</div>
    <?php endif; ?>
  </div>
  <div class="panel-dropdown panel-notifications topbar-dropdown" hidden>
    <div class="panel-header">Notificações</div>
    <?php if (!empty($notifications)): ?>
      <?php foreach ($notifications as $notification): ?>
        <div class="panel-item notification-unread">
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="panel-empty">Nenhuma notificação nova.</div>
    <?php endif; ?>
  </div>
