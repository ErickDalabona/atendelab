<?php
declare(strict_types=1);

class DashboardController
{
    public function resumo(): void
    {
        require_once __DIR__ . '/../../config/database.php';
        $pdo = getConnection();

        $totalPessoas = $pdo->query("SELECT COUNT(*) FROM pessoas")->fetchColumn();
        $totalTipos = $pdo->query("SELECT COUNT(*) FROM tipos_atendimentos")->fetchColumn();
        $totalAtendimentos = $pdo->query("SELECT COUNT(*) FROM atendimentos")->fetchColumn();

        $recentes = $pdo->query("
            SELECT a.id, p.nome AS pessoa, t.nome AS tipo, a.status, a.data_atendimento
            FROM atendimentos a
            JOIN pessoas p ON p.id = a.pessoa_id
            JOIN tipos_atendimentos t ON t.id = a.tipo_atendimento_id
            ORDER BY a.id DESC
            LIMIT 5
        ")->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode([
            'indicadores' => [
                'total_pessoas' => $totalPessoas,
                'total_tipos' => $totalTipos,
                'total_atendimentos' => $totalAtendimentos,
            ],
            'atendimentos_recentes' => $recentes
        ]);
    }
}