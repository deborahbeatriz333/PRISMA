<?php
// Garante que $data exista se o editor abrir este arquivo isoladamente.
$data = $data ?? [
    'profile' => ['name' => 'Usuário'],
    'students' => [],
    'notes' => [],
    'medications' => [],
    'events' => [],
];
?>
<section class="page-section dashboard-section" id="dashboard">
  <!-- Página principal que reúne o resumo mais importante do sistema. -->
  <div class="section-header">
    <div>
      <span class="section-label">Visão geral</span>
      <h1>Dashboard</h1>
    </div>
  </div>

  <div class="dashboard-grid">
    <section class="card summary-card">
      <h2>Olá, <?= htmlspecialchars($data['profile']['name'] ?? 'Usuário', ENT_QUOTES, 'UTF-8') ?></h2>
      <p>Esta página mostra os principais números do Prisma em um só lugar.</p>
    </section>

    <section class="card stat-card">
      <h3>Alunos cadastrados</h3>
      <strong><?= count($data['students']) ?></strong>
      <p>Quantidade de alunos atualmente registrados.</p>
    </section>

    <section class="card stat-card">
      <h3>Anotações</h3>
      <strong><?= count($data['notes']) ?></strong>
      <p>Total de anotações salvas no sistema.</p>
    </section>

    <section class="card stat-card">
      <h3>Medicamentos</h3>
      <strong><?= count($data['medications']) ?></strong>
      <p>Doses e horários registrados.</p>
    </section>

    <section class="card stat-card">
      <h3>Eventos agendados</h3>
      <strong><?= count($data['events']) ?></strong>
      <p>Próximas datas importantes do calendário.</p>
    </section>
  </div>
</section>
