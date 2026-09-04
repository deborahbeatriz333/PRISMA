<?php
// Garante que a variável $user exista antes de usar, mesmo quando o arquivo for analisado isoladamente.
$user = $user ?? [
    'name' => 'Usuário',
    'email' => '',
];
?>
<aside class="sidebar">
  <!-- Barra lateral com links para as páginas principais do sistema. -->
  <div class="sidebar-brand">
    <div class="logo-mark"><img src="assets/img/logo.svg" alt="Logo Prisma"></div>
    <div>
      <span class="brand-title">Prisma</span>
      <small>Gestão escolar</small>
    </div>
  </div>
  <div class="user-info">
    <div class="avatar"></div>
    <div>
      <strong><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></strong>
      <small><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></small>
    </div>
  </div>
  <nav class="sidebar-nav">
    <?php $currentPage = $_GET['page'] ?? 'dashboard'; ?>
    <a href="index.php?page=dashboard" class="nav-link<?= $currentPage === 'dashboard' ? ' active' : '' ?>">Home</a>
    <a href="index.php?page=medicamentos" class="nav-link<?= $currentPage === 'medicamentos' ? ' active' : '' ?>">Medicamentos</a>
    <a href="index.php?page=perfil" class="nav-link<?= $currentPage === 'perfil' ? ' active' : '' ?>">Perfil</a>
    <a href="index.php?page=anotacoes" class="nav-link<?= $currentPage === 'anotacoes' ? ' active' : '' ?>">Anotações</a>
    <a href="index.php?page=calendario" class="nav-link<?= $currentPage === 'calendario' ? ' active' : '' ?>">Calendário</a>
    <a href="index.php?page=alunos" class="nav-link<?= $currentPage === 'alunos' ? ' active' : '' ?>">Alunos</a>
  </nav>
  <div class="sidebar-footer">
    <a href="logout.php" class="secondary-btn">← Sair</a>
  </div>
</aside>
