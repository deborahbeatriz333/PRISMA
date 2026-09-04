<?php
// Garante que $data esteja definido, evitando avisos de editor quando esta página for analisada sozinha.
$data = $data ?? ['students' => []];
?>
<section class="page-section alunos-section" id="alunos">
  <!-- Esta página permite cadastrar, listar e excluir alunos do sistema. -->
  <div class="section-header">
    <div>
      <span class="section-label">Gestão de alunos</span>
      <h1>Alunos</h1>
    </div>
  </div>

  <section id="new-student-form" class="card panel-wrapper section-spaced">
    <h2>Novo aluno</h2>
    <form method="post" class="data-form">
      <input type="hidden" name="action" value="add_student" />
      <label>Nome do aluno<input type="text" name="student_name" placeholder="Nome completo" required /></label>
      <label>Turma<input type="text" name="student_class" placeholder="2º ano" required /></label>
      <label>Idade<input type="number" name="student_age" placeholder="14" min="1" required /></label>
      <label>Status<select name="student_status" required>
        <option>Ativo</option>
        <option>Urgente</option>
        <option>Atenção</option>
        <option>Estável</option>
      </select></label>
      <button type="submit" class="primary-btn">Adicionar aluno</button>
    </form>
  </section>

  <div class="card">
    <div class="panel-title"><h2>Lista de alunos</h2><span>Filtrar por turma</span></div>
    <table>
      <thead>
        <tr><th>Nome</th><th>Turma</th><th>Idade</th><th>Status</th><th>Ação</th></tr>
      </thead>
      <tbody>
        <?php foreach ($data['students'] as $index => $student): ?>
          <tr>
            <td><?= htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($student['class'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($student['age'], ENT_QUOTES, 'UTF-8') ?></td>
            <td class="badge badge-<?= strtolower($student['status'] === 'Urgente' ? 'danger' : ($student['status'] === 'Atenção' ? 'warning' : ($student['status'] === 'Estável' ? 'success' : 'info'))) ?>"><?= htmlspecialchars($student['status'], ENT_QUOTES, 'UTF-8') ?></td>
            <td>
              <form method="post" class="inline-delete">
                <input type="hidden" name="action" value="delete_student" />
                <input type="hidden" name="item_index" value="<?= $index ?>" />
                <button type="submit" class="delete-btn">Excluir</button>
              </form>
              <!-- PDF -->
              <a href="/Prisma/pages/gerar_pdf.php?index=<?= $index ?>" target="_blank" class="btn-pdf" style="margin-top: 5px; display: inline-block; text-decoration: none; font-size: 12px;">
    🖨️ PDF
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
