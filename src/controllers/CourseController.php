<?php
class CourseController {
    public static function register(int $studentId, int $courseId): array {
        $ok = Registration::register($studentId, $courseId);
        return $ok
            ? ['ok' => true,  'msg' => 'Successfully registered!']
            : ['ok' => false, 'msg' => 'Could not register — course full or already enrolled.'];
    }

    public static function drop(int $studentId, int $courseId): array {
        $ok = Registration::drop($studentId, $courseId);
        return $ok
            ? ['ok' => true,  'msg' => 'Course dropped.']
            : ['ok' => false, 'msg' => 'Could not drop course.'];
    }
}
