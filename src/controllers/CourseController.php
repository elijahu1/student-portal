<?php
class CourseController {
    public static function register(int $studentId, int $courseId): array {
        return Registration::register($studentId, $courseId);
    }

    public static function drop(int $studentId, int $courseId): array {
        return Registration::drop($studentId, $courseId);
    }
}
