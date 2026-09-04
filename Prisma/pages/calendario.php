<?php
// Garante que $data esteja definido, evitando avisos de editor quando esta página for analisada sozinha.
$data = $data ?? ['events' => []];
?>
<section class="page-section calendario-section" id="calendario">
  <!-- Esta página organiza eventos e datas importantes da escola. -->
  <div class="section-header">
    <div>
      <span class="section-label">Planejamento</span>
      <h1>Calendário</h1>
    </div>
  </div>

  <section id="new-event-form" class="card panel-wrapper">
    <h2>Novo evento</h2>
    <form method="post" class="data-form">
      <input type="hidden" name="action" value="add_event" />
      <label>Data<input type="text" name="event_date" placeholder="05/07" required /></label>
      <label>Título<input type="text" name="event_title" placeholder="Reunião pedagógica" required /></label>
      <button type="submit" class="primary-btn">Adicionar evento</button>
    </form>
  </section>

  <div class="card">
    <h2>Próximas datas</h2>
    <ul class="event-list">
      <?php foreach ($data['events'] as $index => $event): ?>
        <li>
          <strong><?= htmlspecialchars($event['date'], ENT_QUOTES, 'UTF-8') ?></strong> - <?= htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8') ?>
          <form method="post" class="inline-delete">
            <input type="hidden" name="action" value="delete_event" />
            <input type="hidden" name="item_index" value="<?= $index ?>" />
            <button type="submit" class="delete-btn">Excluir</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
