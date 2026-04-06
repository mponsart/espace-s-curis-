<?php
declare(strict_types=1);

namespace App\Models;

final class UserModel extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        return $user ?: null;
    }

    public function create(string $name, string $email, string $avatar): array
    {
        $statement = $this->db->prepare(
            'INSERT INTO users (name, email, avatar, role, created_at)
             VALUES (:name, :email, :avatar, :role, CURRENT_TIMESTAMP)'
        );
        $statement->execute([
            'name' => $name,
            'email' => $email,
            'avatar' => $avatar,
            'role' => 'admin',
        ]);

        return $this->findByEmail($email) ?? [];
    }

    public function updateProfile(int $id, string $name, string $avatar): void
    {
        $statement = $this->db->prepare('UPDATE users SET name = :name, avatar = :avatar WHERE id = :id');
        $statement->execute([
            'id' => $id,
            'name' => $name,
            'avatar' => $avatar,
        ]);
    }
}