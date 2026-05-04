<?php
class Course {
    public static function all(): array {
        return db()->query('SELECT * FROM courses ORDER BY code')->fetchAll();
    }

    public static function find(int $id): ?array {
        $stmt = db()->prepare('SELECT * FROM courses WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $d): int {
        $stmt = db()->prepare('INSERT INTO courses (code,title,description,credits,capacity,semester) VALUES (?,?,?,?,?,?)');
        $stmt->execute([$d['code'], $d['title'], $d['description'], $d['credits'], $d['capacity'], $d['semester']]);
        return (int)db()->lastInsertId();
    }

    public static function update(int $id, array $d): void {
        $stmt = db()->prepare('UPDATE courses SET code=?,title=?,description=?,credits=?,capacity=?,semester=? WHERE id=?');
        $stmt->execute([$d['code'], $d['title'], $d['description'], $d['credits'], $d['capacity'], $d['semester'], $id]);
    }

    public static function delete(int $id): void {
        db()->prepare('DELETE FROM courses WHERE id=?')->execute([$id]);
    }

    public static function incrementEnrolled(int $id): void {
        db()->prepare('UPDATE courses SET enrolled = enrolled + 1 WHERE id = ?')->execute([$id]);
    }

    public static function decrementEnrolled(int $id): void {
        db()->prepare('UPDATE courses SET enrolled = GREATEST(enrolled - 1, 0) WHERE id = ?')->execute([$id]);
    }
}
