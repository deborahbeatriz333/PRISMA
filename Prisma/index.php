<?php
// Inicia a sessão para lembrar quem está usando o sistema.
session_start();
// Carrega as funções e os dados salvos do projeto.
require __DIR__ . '/includes/data.php';

// Lista das páginas que o usuário pode acessar. Isso evita erros e páginas inválidas.
$allowedPages = ['dashboard', 'perfil', 'medicamentos', 'anotacoes', 'calendario', 'alunos'];
$page = $_GET['page'] ?? 'dashboard';
if (!in_array($page, $allowedPages, true)) {
    $page = 'dashboard';
}

switch ($page) {
    case 'perfil':
        $pageTitle = 'Perfil';
        break;
    case 'medicamentos':
        $pageTitle = 'Medicamentos';
        break;
    case 'anotacoes':
        $pageTitle = 'Anotações';
        break;
    case 'calendario':
        $pageTitle = 'Calendário';
        break;
    case 'alunos':
        $pageTitle = 'Alunos';
        break;
    default:
        $pageTitle = 'Dashboard';
}

$data = load_data();

function add_notification(array &$data, string $title, string $text): void
{
    $data['notifications'][] = [
        'title' => $title,
        'text' => $text,
        'read' => false,
    ];
}

$statusMessage = $_GET['status'] ?? '';

if (isset($_REQUEST['mark_notifications_read'])) {
    foreach ($data['notifications'] as &$notification) {
        $notification['read'] = true;
    }
    save_data($data);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        echo json_encode(['ok' => true]);
        exit;
    }
    header('Location: index.php?page=' . urlencode($page));
    exit;
}

$searchQuery = trim($_GET['search'] ?? '');
if ($page === 'alunos' && $searchQuery !== '') {
    $data['students'] = array_values(array_filter($data['students'], function ($student) use ($searchQuery) {
        $needle = mb_strtolower($searchQuery, 'UTF-8');
        return mb_stripos(mb_strtolower($student['name'], 'UTF-8'), $needle) !== false
            || mb_stripos(mb_strtolower($student['class'], 'UTF-8'), $needle) !== false
            || mb_strpos((string) $student['age'], $needle) !== false
            || mb_stripos(mb_strtolower($student['status'], 'UTF-8'), $needle) !== false;
    }));
}

// Se o usuário enviou um formulário, o sistema decide qual ação fazer.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    switch ($action) {
        case 'add_student':
            $name = trim($_POST['student_name'] ?? '');
            $class = trim($_POST['student_class'] ?? '');
            $age = (int) ($_POST['student_age'] ?? 0);
            $status = trim($_POST['student_status'] ?? 'Ativo');
            if ($name && $class && $age > 0) {
                $data['students'][] = [
                    'name' => $name,
                    'class' => $class,
                    'age' => $age,
                    'status' => $status,
                ];
                add_notification($data, 'Aluno adicionado', "O aluno $name foi registrado no sistema.");
                save_data($data);
                header('Location: index.php?page=alunos&status=' . urlencode('Aluno adicionado com sucesso.'));
                exit;
            }
            $statusMessage = 'Preencha todos os campos do novo aluno.';
            break;
        case 'add_event':
            $date = trim($_POST['event_date'] ?? '');
            $title = trim($_POST['event_title'] ?? '');
            if ($date && $title) {
                $data['events'][] = ['date' => $date, 'title' => $title];
                add_notification($data, 'Evento agendado', "O evento '$title' foi adicionado para $date.");
                save_data($data);
                header('Location: index.php?page=calendario&status=' . urlencode('Evento adicionado com sucesso.'));
                exit;
            }
            $statusMessage = 'Preencha a data e o título do evento.';
            break;
        case 'add_note':
            $student = trim($_POST['note_student'] ?? '');
            $class = trim($_POST['note_class'] ?? '');
            $status = trim($_POST['note_status'] ?? '');
            $meta = trim($_POST['note_meta'] ?? '');
            $content = trim($_POST['note_content'] ?? '');
            if ($student && $class && $status && $content) {
                $data['notes'][] = [
                    'student' => $student,
                    'class' => $class,
                    'status' => $status,
                    'meta' => $meta,
                    'content' => $content,
                ];
                add_notification($data, 'Nova anotação', "Anotação salva para $student ($class).",
                );
                save_data($data);
                header('Location: index.php?page=anotacoes&status=' . urlencode('Anotação salva com sucesso.'));
                exit;
            }
            $statusMessage = 'Preencha os dados da anotação antes de salvar.';
            break;
        case 'update_profile':
            $data['profile']['name'] = trim($_POST['profile_name'] ?? $data['profile']['name']);
            $data['profile']['email'] = trim($_POST['profile_email'] ?? $data['profile']['email']);
            $data['profile']['phone'] = trim($_POST['profile_phone'] ?? $data['profile']['phone']);
            $data['profile']['turmas'] = trim($_POST['profile_turmas'] ?? $data['profile']['turmas']);
            add_notification($data, 'Perfil atualizado', 'Os dados do perfil foram alterados com sucesso.');
            save_data($data);
            header('Location: index.php?page=perfil&status=' . urlencode('Perfil atualizado com sucesso.'));
            exit;
        case 'update_password':
            $password = trim($_POST['new_password'] ?? '');
            $confirm = trim($_POST['confirm_password'] ?? '');
            if ($password && $password === $confirm) {
                $data['auth']['password'] = $password;
                add_notification($data, 'Senha alterada', 'A senha da conta foi atualizada com sucesso.');
                save_data($data);
                header('Location: index.php?page=perfil&status=' . urlencode('Senha atualizada com sucesso.'));
                exit;
            }
            $statusMessage = 'As senhas devem coincidir e não podem estar vazias.';
            break;
        case 'add_medication':
            $name = trim($_POST['medicine_name'] ?? '');
            $dose = trim($_POST['medicine_dose'] ?? '');
            $time = trim($_POST['medicine_time'] ?? '');
            if ($name && $dose && $time) {
                $data['medications'][] = [
                    'name' => $name,
                    'dose' => $dose,
                    'time' => $time,
                ];
                add_notification($data, 'Dose adicionada', "A dose $name às $time foi registrada.");
                save_data($data);
                header('Location: index.php?page=medicamentos&status=' . urlencode('Dose adicionada com sucesso.'));
                exit;
            }
            $statusMessage = 'Preencha todos os campos para adicionar a dose.';
            break;
        case 'delete_student':
            $index = isset($_POST['item_index']) ? (int) $_POST['item_index'] : -1;
            if (isset($data['students'][$index])) {
                $deletedName = $data['students'][$index]['name'];
                array_splice($data['students'], $index, 1);
                add_notification($data, 'Aluno excluído', "O aluno $deletedName foi removido do sistema.");
                save_data($data);
                header('Location: index.php?page=alunos&status=' . urlencode('Aluno excluído com sucesso.'));
                exit;
            }
            $statusMessage = 'Aluno não encontrado.';
            break;
        case 'delete_event':
            $index = isset($_POST['item_index']) ? (int) $_POST['item_index'] : -1;
            if (isset($data['events'][$index])) {
                $deletedTitle = $data['events'][$index]['title'];
                array_splice($data['events'], $index, 1);
                add_notification($data, 'Evento excluído', "O evento '$deletedTitle' foi removido do calendário.");
                save_data($data);
                header('Location: index.php?page=calendario&status=' . urlencode('Evento excluído com sucesso.'));
                exit;
            }
            $statusMessage = 'Evento não encontrado.';
            break;
        case 'delete_note':
            $index = isset($_POST['item_index']) ? (int) $_POST['item_index'] : -1;
            if (isset($data['notes'][$index])) {
                $deletedStudent = $data['notes'][$index]['student'];
                array_splice($data['notes'], $index, 1);
                add_notification($data, 'Anotação excluída', "A anotação de $deletedStudent foi removida.");
                save_data($data);
                header('Location: index.php?page=anotacoes&status=' . urlencode('Anotação excluída com sucesso.'));
                exit;
            }
            $statusMessage = 'Anotação não encontrada.';
            break;
        case 'delete_medication':
            $index = isset($_POST['item_index']) ? (int) $_POST['item_index'] : -1;
            if (isset($data['medications'][$index])) {
                $deletedMedicine = $data['medications'][$index]['name'];
                array_splice($data['medications'], $index, 1);
                add_notification($data, 'Dose excluída', "A dose de $deletedMedicine foi removida.");
                save_data($data);
                header('Location: index.php?page=medicamentos&status=' . urlencode('Dose excluída com sucesso.'));
                exit;
            }
            $statusMessage = 'Dose não encontrada.';
            break;
    }
}
?>
<?php
// Depois de preparar os dados, o sistema monta a página com o cabeçalho e a barra lateral.
include __DIR__ . '/includes/header.php';
?>
<div class="app-shell">
  <?php include __DIR__ . '/includes/sidebar.php'; ?>
  <main class="content">
    <?php if ($statusMessage): ?>
      <div class="status-banner"><?= htmlspecialchars($statusMessage, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php include __DIR__ . '/pages/' . $page . '.php'; ?>
  </main>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
