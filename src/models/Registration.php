<?php
define('MAX_CREDITS', 18);

class Registration {
    public static function forStudent(int $studentId): array {
        $stmt = db()->prepare(
            'SELECT r.*, c.code, c.title, c.credits, c.semester
             FROM registrations r
             JOIN courses c ON c.id = r.course_id
             WHERE r.student_id = ?
             ORDER BY r.registered_at DESC'
        );
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public static function isRegistered(int $studentId, int $courseId): bool {
        $stmt = db()->prepare('SELECT 1 FROM registrations WHERE student_id=? AND course_id=?');
        $stmt->execute([$studentId, $courseId]);
        return (bool)$stmt->fetch();
    }

    public static function totalCredits(int $studentId): int {
        $stmt = db()->prepare(
            'SELECT COALESCE(SUM(c.credits), 0) as total
             FROM registrations r
             JOIN courses c ON c.id = r.course_id
             WHERE r.student_id = ?'
        );
        $stmt->execute([$studentId]);
        return (int)$stmt->fetch()['total'];
    }

    public static function register(int $studentId, int $courseId): array {
        $course = Course::find($courseId);
        if (!$course || $course['enrolled'] >= $course['capacity'])
            return ['ok' => false, 'msg' => 'Course is full.'];
        if (self::isRegistered($studentId, $courseId))
            return ['ok' => false, 'msg' => 'Already registered for this course.'];

        $currentCredits = self::totalCredits($studentId);
        if ($currentCredits + $course['credits'] > MAX_CREDITS)
            return ['ok' => false, 'msg' => "Credit limit reached. Max " . MAX_CREDITS . " credits per semester."];

        db()->prepare('INSERT INTO registrations (student_id, course_id) VALUES (?,?)')->execute([$studentId, $courseId]);
        Course::incrementEnrolled($courseId);
        return ['ok' => true, 'msg' => 'Successfully registered!'];
    }

    public static function drop(int $studentId, int $courseId): array {
        if (!self::isRegistered($studentId, $courseId))
            return ['ok' => false, 'msg' => 'Not registered for this course.'];
        db()->prepare('DELETE FROM registrations WHERE student_id=? AND course_id=?')->execute([$studentId, $courseId]);
        Course::decrementEnrolled($courseId);
        return ['ok' => true, 'msg' => 'Course dropped.'];
    }

    public static function allWithDetails(): array {
        return db()->query(
            'SELECT r.id, r.registered_at, u.name AS student, u.email, c.code, c.title
             FROM registrations r
             JOIN users u ON u.id = r.student_id
             JOIN courses c ON c.id = r.course_id
             ORDER BY r.registered_at DESC'
        )->fetchAll();
    }
}
