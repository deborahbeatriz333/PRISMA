<?php
require_once('../libs/fpdf.php');
require_once('../includes/data.php');

$data = load_data();
$index = isset($_REQUEST['index']) ? (int)$_REQUEST['index'] : -1;

if (!isset($data['students'][$index])) {
    die("Estudante não encontrado.");
}

$student = $data['students'][$index];

// SE O FORMULÁRIO FOI ENVIADO (Gera o PDF com as observações digitadas)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $observacoesCustom = $_POST['observacoes'] ?? '';

    class PDF extends FPDF {
        // Cabeçalho com apenas a Logo do CEMI
        function Header() {
            // Logo do CEMI centralizada ou à direita (Ajuste o X para 95 para centralizar perfeitamente)
            $logo = '../assets/img/logo_cemi.png';
            if (file_exists($logo)) {
                // X: 95 centraliza a logo (considerando largura de 20mm), Y: 10
                $this->Image($logo, 95, 8, 20);
            }

            // Espaço para afastar o texto da logo
            $this->Ln(20);

            // Textos do Cabeçalho centralizados
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 5, utf8_decode('GOVERNO DO DISTRITO FEDERAL'), 0, 1, 'C');
            $this->Cell(0, 5, utf8_decode('SECRETARIA DE ESTADO DE EDUCAÇÃO'), 0, 1, 'C');
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 5, utf8_decode('CENTRO DE ENSINO MÉDIO INTEGRADO DO GAMA'), 0, 1, 'C');
            
            $this->SetFont('Arial', '', );
            $this->Cell(0, 5, utf8_decode('Plataforma PRISMA - Monitoramento Biopsicossocial'), 0, 1, 'C');
            $this->Ln(10); // Espaço após o cabeçalho
        }

        // Rodapé oficial
        function Footer() {
            $this->SetY(-25);
            
            // Linha divisória sutil
            $this->SetDrawColor(200, 200, 200);
            $this->Line(10, $this->GetY(), 200, $this->GetY());
            $this->Ln(2);

            // Informações de Rodapé
            $this->SetFont('Arial', 'I', 10);
            $this->MultiCell(0, 3.5, utf8_decode('Documento gerado eletronicamente pela Plataforma PRISMA. A autenticidade deste documento pode ser validada junto à Orientação Educacional do CEMI Gama.'), 0, 'C');
            
            $this->Ln(2);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 4, utf8_decode('Serviço de Orientação Educacional'), 0, 1, 'C');
            
            // Número da página
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 4, utf8_decode('Pág. ' . $this->PageNo()), 0, 0, 'C');
        }
    }

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 13);

    // Título do Relatório
    $pdf->Cell(0, 8, utf8_decode('RELATÓRIO DE ENCAMINHAMENTO / PARECER TÉCNICO'), 0, 1, 'C');
    $pdf->Ln(4);

    // Dados do Aluno
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 6, utf8_decode('Nome do Estudante: ' . $student['name']), 0, 1);
    $pdf->Cell(0, 6, utf8_decode('Turma: ' . $student['class'] . '    |    Idade: ' . $student['age'] . ' anos'), 0, 1);
    $pdf->Cell(0, 6, utf8_decode('Status de Triagem: ' . $student['status']), 0, 1);
    $pdf->Cell(0, 6, utf8_decode('Data de Emissão: ' . date('d/m/Y H:i')), 0, 1);
    $pdf->Ln(6);

    // Seção 1
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 6, utf8_decode('1. Histórico e Observações da Orientação Pedagógica:'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 5.5, utf8_decode($observacoesCustom));
    $pdf->Ln(4);

    // Seção 2
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 6, utf8_decode('2. Encaminhamento Proposto:'), 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 5.5, utf8_decode('Encaminhado para acompanhamento especializado externo conforme os protocolos de apoio biopsicossocial da rede pública de ensino do Distrito Federal.'));
    
    // Saída do PDF
    $pdf->Output('I', 'Relatorio_' . $index . '.pdf');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerar Parecer - PRISMA</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; padding: 40px; }
        .card { background: white; padding: 30px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; margin-top: 0; }
        textarea { width: 100%; height: 140px; padding: 10px; margin-top: 10px; border-radius: 4px; border: 1px solid #ccc; font-family: sans-serif; font-size: 14px; box-sizing: border-box; }
        button { background-color: #2c3e50; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; margin-top: 15px; font-weight: bold; font-size: 14px; }
        button:hover { background-color: #34495e; }
        p { color: #555; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Parecer do Aluno: <?= htmlspecialchars($student['name']) ?></h2>
        <p>Edite ou adicione abaixo as observações pedagógicas antes de emitir o documento oficial:</p>
        <form method="POST">
            <input type="hidden" name="index" value="<?= $index ?>">
            <textarea name="observacoes" required>O estudante apresenta acompanhamento regular registrado na plataforma PRISMA, com foco no suporte biopsicossocial e acompanhamento de frequência/rendimento escolar.</textarea>
            <br>
            <button type="submit">Gerar PDF Oficial</button>
        </form>
    </div>
</body>
</html>