<?php
// Garante que $data esteja definido, evitando avisos de editor quando esta página for analisada sozinha.
$data = $data ?? ['profile' => ['name' => '', 'email' => '', 'phone' => '', 'turmas' => '', 'status' => '']];
?>
<section class="page-section perfil-section" id="perfil">
  <!-- Página do perfil, com dados do usuário e formulário para editar informações. -->
  <div class="section-header">
    <div>
      <span class="section-label">Conta</span>
      <h1>Perfil do Usuário</h1>
    </div>
  </div>

  <div class="perfil-grid">
    <section class="card profile-card">
      <div class="profile-top">
        <div class="profile-avatar large"></div>
        <div>
          <h2><?= htmlspecialchars($data['profile']['name'], ENT_QUOTES, 'UTF-8') ?></h2>
          <p>Coordenadora pedagógica</p>
        </div>
        <span class="badge badge-success">Ativo</span>
      </div>
      <div class="profile-details">
        <div><strong>Email</strong><p><?= htmlspecialchars($data['profile']['email'], ENT_QUOTES, 'UTF-8') ?></p></div>
        <div><strong>Telefone</strong><p><?= htmlspecialchars($data['profile']['phone'], ENT_QUOTES, 'UTF-8') ?></p></div>
        <div><strong>Turmas</strong><p><?= htmlspecialchars($data['profile']['turmas'], ENT_QUOTES, 'UTF-8') ?></p></div>
        <div><strong>Status</strong><p><?= htmlspecialchars($data['profile']['status'], ENT_QUOTES, 'UTF-8') ?></p></div>
      </div>
    </section>

    <section id="edit-profile-form" class="card form-card">
      <h2>Atualizar informações</h2>
      <form method="post" class="data-form">
        <input type="hidden" name="action" value="update_profile" />
        <label>Nome completo<input type="text" name="profile_name" value="<?= htmlspecialchars($data['profile']['name'], ENT_QUOTES, 'UTF-8') ?>" required /></label>
        <label>Email<input type="email" name="profile_email" value="<?= htmlspecialchars($data['profile']['email'], ENT_QUOTES, 'UTF-8') ?>" required /></label>
        <label>Telefone<input type="tel" name="profile_phone" value="<?= htmlspecialchars($data['profile']['phone'], ENT_QUOTES, 'UTF-8') ?>" required /></label>
        <label>Turmas<input type="text" name="profile_turmas" value="<?= htmlspecialchars($data['profile']['turmas'], ENT_QUOTES, 'UTF-8') ?>" required /></label>
        <button type="submit" class="primary-btn">Salvar mudanças</button>
      </form>
    </section>
  </div>

  <div class="perfil-grid">
    <section class="card password-card">
      <h2>Redefinir senha</h2>
      <form method="post" class="data-form">
        <input type="hidden" name="action" value="update_password" />
        <label>Nova senha<input type="password" name="new_password" placeholder="••••••••" required /></label>
        <label>Confirmar senha<input type="password" name="confirm_password" placeholder="••••••••" required /></label>
        <button type="submit" class="primary-btn">Atualizar senha</button>
      </form>
    </section>

    <section class="card note-card">
      <h2>Observações</h2>
      <p>O perfil do usuário está atualizado e sincronizado com o registro escolar. Use a área abaixo para anotações rápidas ou lembretes.</p>
      <textarea placeholder="Adicionar observação..." rows="8"></textarea>
    </section>
  </div>
</section>
