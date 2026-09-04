<?php
// Este arquivo guarda os dados do sistema e as funções para ler e salvar as informações.
function get_data_path(): string
{
    return __DIR__ . '/../database/data.json';
}

function get_default_data(): array
{
    return [
        'auth' => [
            'email' => 'admin@prisma.local',
            'password' => 'Prisma123!',
        ],
        'profile' => [
            'name' => 'Patrícia',
            'email' => 'patricia@prisma.com',
            'phone' => '(99) 99876-5432',
            'turmas' => '1º ano, 2º ano, 3º ano',
            'status' => 'Disponível',
        ],
        'students' => [
            ['name' => 'João Alves', 'class' => '2º ano', 'age' => 14, 'status' => 'Urgente'],
            ['name' => 'Maria Silva', 'class' => '1º ano', 'age' => 13, 'status' => 'Atenção'],
            ['name' => 'Lucas Pereira', 'class' => '3º ano', 'age' => 15, 'status' => 'Estável'],
        ],
        'events' => [
            ['date' => '05/07', 'title' => 'Reunião pedagógica'],
            ['date' => '08/07', 'title' => 'Entrega de relatório'],
            ['date' => '13/07', 'title' => 'Consulta de medicação'],
        ],
        'notes' => [
            [
                'student' => 'João Alves',
                'class' => '2º ano',
                'status' => 'Urgente',
                'meta' => 'TDAH • 15/03/2012 • 14 anos',
                'content' => 'O aluno apresenta dificuldades de concentração e precisa de acompanhamento semanal.',
            ],
        ],
        'medications' => [
            ['name' => 'Paracetamol', 'dose' => '500mg', 'time' => '15:00'],
        ],
        'messages' => [],
        'notifications' => [],
    ];
}

function load_data(): array
{
    $path = get_data_path();
    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0777, true);
    }
    if (!file_exists($path)) {
        $data = get_default_data();
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $data;
    }
    $data = json_decode(file_get_contents($path), true);
    if (!is_array($data)) {
        return get_default_data();
    }

    $updated = false;
    if (!empty($data['notifications']) && is_array($data['notifications'])) {
        foreach ($data['notifications'] as &$notification) {
            if (!array_key_exists('read', $notification)) {
                $notification['read'] = true;
                $updated = true;
            }
        }
        unset($notification);
    }

    if ($updated) {
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    return $data;
}

function save_data(array $data): bool
{
    return file_put_contents(get_data_path(), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}
