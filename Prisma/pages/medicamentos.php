<?php
// Garante que $data esteja definido, evitando avisos de editor quando esta página for analisada sozinha.
$data = $data ?? ['medications' => []];
?>
<section class="page-section medicamentos-section" id="medicamentos">
  <!-- Esta área controla as doses e os horários dos medicamentos. -->
  <div class="section-header">
    <div>
      <span class="section-label">Saúde</span>
      <h1>Medicamentos</h1>
    </div>
    <button class="primary-btn toggle-form" data-panel="new-medication-form">Adicionar dose</button>
  </div>

  <section id="new-medication-form" class="card panel-wrapper hidden">
    <h2>Adicionar dose</h2>
    <form method="post" class="data-form">
      <input type="hidden" name="action" value="add_medication" />
      <label>Medicamento<input type="text" name="medicine_name" placeholder="Ritalina" required /></label>
      <label>Dose<input type="text" name="medicine_dose" placeholder="10mg" required /></label>
      <label>Horário<input type="text" name="medicine_time" placeholder="08:00" required /></label>
      <button type="submit" class="primary-btn">Salvar dose</button>
    </form>
  </section>

  <div class="dashboard-grid">
    <section class="card medication-card">
      <div class="panel-title"><h2>Agenda de medicação</h2><span>Controle diário</span></div>
      <table>
        <thead>
          <tr><th>Medicamento</th><th>Dose</th><th>Horário</th><th>Status</th><th>Ação</th></tr>
        </thead>
        <tbody>
          <?php foreach ($data['medications'] as $index => $medicine): ?>
            <tr>
              <td><?= htmlspecialchars($medicine['name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($medicine['dose'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($medicine['time'], ENT_QUOTES, 'UTF-8') ?></td>
              <td class="badge badge-info">Agendado</td>
              <td>
                <form method="post" class="inline-delete">
                  <input type="hidden" name="action" value="delete_medication" />
                  <input type="hidden" name="item_index" value="<?= $index ?>" />
                  <button type="submit" class="delete-btn">Excluir</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
    <section class="card info-card">
      <h2>Indicadores</h2>
      <div class="indicator-row"><span>Próxima dose</span><strong><?= htmlspecialchars($data['medications'][0]['time'] ?? '---', ENT_QUOTES, 'UTF-8') ?></strong></div>
      <div class="indicator-row"><span>Total hoje</span><strong><?= count($data['medications']) ?> doses</strong></div>
      <div class="indicator-row"><span>Relatórios</span><strong>5 pendentes</strong></div>
    </section>
  </div>
</section>
