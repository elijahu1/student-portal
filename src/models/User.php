<?php
class User {
    public static function findByEmail(string $email): ?array {
        $stmt = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function findById(int $id): ?array {
        $stmt = db()->prepare('SELECT id, name, email, role, created_at FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(string $name, string $email, string $password, string $role = 'student'): int {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = db()->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?,?,?,?)');
        $stmt->execute([$name, $email, $hash, $role]);
        return (int)db()->lastInsertId();
    }

    public static function all(): array {
        return db()->query('SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC')->fetchAll();
    }
}
