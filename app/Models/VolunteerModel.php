<?php
declare(strict_types=1);

namespace App\Models;

use PDO;

final class VolunteerModel extends BaseModel
{
    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM volunteers')->fetchColumn();
    }

    public function recent(int $limit = 5): array
    {
        $statement = $this->db->prepare(
            'SELECT id, first_name, last_name, email, created_at
             FROM volunteers
             ORDER BY created_at DESC
             LIMIT :limit'
        );
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function paginate(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $statement = $this->db->prepare(
            'SELECT *,
                    CASE WHEN first_name IS NOT NULL AND first_name != "" AND last_name IS NOT NULL AND last_name != "" AND consent_rgpd = 1 THEN 1 ELSE 0 END AS is_completed
             FROM volunteers
             ORDER BY created_at DESC
             LIMIT :limit OFFSET :offset'
        );
        $statement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM volunteers WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $volunteer = $statement->fetch();

        return $volunteer ?: null;
    }

    public function findByToken(string $token): ?array
    {
        $statement = $this->db->prepare(
            'SELECT *
             FROM volunteers
             WHERE token = :token AND token_expires_at >= CURRENT_TIMESTAMP
             LIMIT 1'
        );
        $statement->execute(['token' => $token]);
        $volunteer = $statement->fetch();

        return $volunteer ?: null;
    }

    public function createInvitation(string $email, string $token, string $expiresAt): int
    {
        $statement = $this->db->prepare(
            'INSERT INTO volunteers (email, token, token_expires_at, consent_rgpd, created_at)
             VALUES (:email, :token, :token_expires_at, 0, CURRENT_TIMESTAMP)'
        );
        $statement->execute([
            'email' => $email,
            'token' => $token,
            'token_expires_at' => $expiresAt,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function updateForm(int $id, array $data): bool
    {
        $statement = $this->db->prepare(
            'UPDATE volunteers
             SET last_name = :last_name,
                 first_name = :first_name,
                 gender = :gender,
                 birth_date = :birth_date,
                 birth_place = :birth_place,
                 nationality = :nationality,
                 email = :email,
                 address = :address,
                 postal_code = :postal_code,
                 city = :city,
                 phone = :phone,
                 emergency_name = :emergency_name,
                 emergency_phone = :emergency_phone,
                 consent_rgpd = :consent_rgpd,
                 validated_at = COALESCE(validated_at, CURRENT_TIMESTAMP)
             WHERE id = :id
               AND (validated_at IS NULL OR validated_at = "")'
        );
        $statement->execute([
            'id' => $id,
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'gender' => $data['gender'] ?: null,
            'birth_date' => $data['birth_date'] ?: null,
            'birth_place' => $data['birth_place'] ?: null,
            'nationality' => $data['nationality'] ?: null,
            'email' => $data['email'],
            'address' => $data['address'] ?: null,
            'postal_code' => $data['postal_code'] ?: null,
            'city' => $data['city'] ?: null,
            'phone' => $data['phone'] ?: null,
            'emergency_name' => $data['emergency_name'] ?: null,
            'emergency_phone' => $data['emergency_phone'] ?: null,
            'consent_rgpd' => (int) $data['consent_rgpd'],
        ]);

        return $statement->rowCount() > 0;
    }

    public function delete(int $id): void
    {
        $statement = $this->db->prepare('DELETE FROM volunteers WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    public function exportRows(): array
    {
        return $this->db->query(
            'SELECT id, last_name, first_name, email, phone, city, created_at
             FROM volunteers
             ORDER BY created_at DESC'
        )->fetchAll();
    }
}
