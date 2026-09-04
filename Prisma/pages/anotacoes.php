<?php
// Garante que $data esteja definido, evitando avisos de editor quando esta página for analisada sozinha.
$data = $data ?? ['notes' => []];
?>
<section class="page-section anotacao-section" id="anotacoes">
  <!-- Aqui ficam as anotações pedagógicas sobre cada aluno. -->
  <div class="section-header">
    <div>
      <span class="section-label">Registro</span>
      <h1>Anotações Pedagógicas</h1>
    </div>
  </div>

  <section id="new-note-form" class="card panel-wrapper">
    <h2>Nova anotação</h2>
    <form method="post" class="data-form">
      <input type="hidden" name="action" value="add_note" />
      <label>Aluno<input type="text" name="note_student" placeholder="Nome do aluno" required /></label>
      <label>Turma<input type="text" name="note_class" placeholder="2º ano" required /></label>
      <label>Status<select name="note_status" required>
        <option>Urgente</option>
        <option>Atenção</option>
        <option>Estável</option>
        <option>Aguardando</option>
      </select></label>
      <label>Meta<input type="text" name="note_meta" placeholder="TDAH • 15/03/2012 • 14 anos" /></label>
      <label>Anotação<textarea name="note_content" placeholder="Digite a observação" rows="6" required></textarea></label>
      <button type="submit" class="primary-btn">Salvar anotação</button>
    </form>
  </section>

  <div class="anotacao-grid">
    <section class="card note-detail-card">
      <div class="panel-title"><h2>Anotações recentes</h2><span><?= count($data['notes']) ?> registros</span></div>
      <?php foreach ($data['notes'] as $index => $note): ?>
        <div class="note-card-item">
          <div class="note-header">
            <div class="student-card">
              <div class="student-avatar"></div>
              <div>
                <h3><?= htmlspecialchars($note['student'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p><?= htmlspecialchars($note['class'], ENT_QUOTES, 'UTF-8') ?></p>
              </div>
            </div>
            <span class="badge badge-<?= strtolower($note['status'] === 'Urgente' ? 'danger' : ($note['status'] === 'Atenção' ? 'warning' : ($note['status'] === 'Estável' ? 'success' : 'info'))) ?>"><?= htmlspecialchars($note['status'], ENT_QUOTES, 'UTF-8') ?></span>
          </div>
          <p class="note-meta"><?= htmlspecialchars($note['meta'], ENT_QUOTES, 'UTF-8') ?></p>
          <p><?= nl2br(htmlspecialchars($note['content'], ENT_QUOTES, 'UTF-8')) ?></p>
          <form method="post" class="inline-delete note-delete">
            <input type="hidden" name="action" value="delete_note" />
            <input type="hidden" name="item_index" value="<?= $index ?>" />
            <button type="submit" class="delete-btn">Excluir</button>
          </form>
        </div>
      <?php endforeach; ?>
    </section>

    <section class="card data-box">
      <h2>Dados importantes</h2>
      <p><strong>Última anotação:</strong> <?= htmlspecialchars($data['notes'][0]['student'] ?? 'Nenhuma', ENT_QUOTES, 'UTF-8') ?></p>
      <p><strong>Total de anotações:</strong> <?= count($data['notes']) ?></p>
      <div class="report-box">
        <label>Reportar ocorrência</label>
        <textarea placeholder="Digite o tipo de ocorrência..."></textarea>
      </div>
    </section>
  </div>
</section>
