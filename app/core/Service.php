<?php

class Service
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function create(int $userId, string $description, float $value): int
    {
        $stmt = $this->db->prepare('INSERT INTO services (description, value, status, user_id) VALUES (:description, :value, :status, :user_id)');
        $stmt->execute([
            'description' => $description,
            'value' => $value,
            'status' => 'Pendente',
            'user_id' => $userId
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function all(array $filters = []): array
    {
        $sql = 'SELECT s.*, u.name as user_name FROM services s JOIN users u ON u.id = s.user_id WHERE 1=1';
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= ' AND s.status = :status';
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['description'])) {
            $sql .= ' AND s.description LIKE :description';
            $params['description'] = '%' . $filters['description'] . '%';
        }

        if (!empty($filters['user_name'])) {
            $sql .= ' AND u.name LIKE :user_name';
            $params['user_name'] = '%' . $filters['user_name'] . '%';
        }

        if (!empty($filters['start']) && !empty($filters['end'])) {
            $sql .= ' AND s.created_at BETWEEN :start AND :end';
            $params['start'] = $filters['start'] . ' 00:00:00';
            $params['end'] = $filters['end'] . ' 23:59:59';
        }

        $sql .= ' ORDER BY s.created_at DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser(int $userId, array $filters = []): array
    {
        $sql = 'SELECT s.*, u.name as user_name FROM services s JOIN users u ON u.id = s.user_id WHERE s.user_id = :user_id';
        $params = ['user_id' => $userId];

        if (!empty($filters['status'])) {
            $sql .= ' AND s.status = :status';
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['description'])) {
            $sql .= ' AND s.description LIKE :description';
            $params['description'] = '%' . $filters['description'] . '%';
        }

        if (!empty($filters['start']) && !empty($filters['end'])) {
            $sql .= ' AND s.created_at BETWEEN :start AND :end';
            $params['start'] = $filters['start'] . ' 00:00:00';
            $params['end'] = $filters['end'] . ' 23:59:59';
        }

        $sql .= ' ORDER BY s.created_at DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT s.*, u.name as user_name FROM services s JOIN users u ON u.id = s.user_id WHERE s.id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);

        return $service ?: null;
    }

    public function update(int $id, string $description, float $value): bool
    {
        $stmt = $this->db->prepare('UPDATE services SET description = :description, value = :value WHERE id = :id');
        return $stmt->execute([
            'description' => $description,
            'value' => $value,
            'id' => $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM services WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function finalize(int $id, float $commission): bool
    {
        $stmt = $this->db->prepare('UPDATE services SET status = :status, finished_at = :finished_at, commission = :commission WHERE id = :id');
        return $stmt->execute([
            'status' => 'Finalizado',
            'finished_at' => date('Y-m-d H:i:s'),
            'commission' => $commission,
            'id' => $id
        ]);
    }

    public function totalValueByUser(int $userId): float
    {
        $stmt = $this->db->prepare('SELECT COALESCE(SUM(value),0) as total FROM services WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (float)$row['total'];
    }

    public function latestPendingByUser(int $userId, int $limit = 5): array
    {
        $stmt = $this->db->prepare('SELECT * FROM services WHERE user_id = :user_id AND status = :status ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':status', 'Pendente');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
