<?php
class AdminController {
    public static function saveCourse(array $d, ?int $id = null): array {
        $d['code']        = strtoupper(trim($d['code'] ?? ''));
        $d['title']       = trim($d['title'] ?? '');
        $d['credits']     = (int)($d['credits'] ?? 3);
        $d['capacity']    = (int)($d['capacity'] ?? 30);
        $d['semester']    = trim($d['semester'] ?? '');
        $d['description'] = trim($d['description'] ?? '');

        if (!$d['code'] || !$d['title'] || !$d['semester'])
            return ['ok' => false, 'msg' => 'Code, title and semester are required.'];

        if ($id) {
            Course::update($id, $d);
            return ['ok' => true, 'msg' => 'Course updated.'];
        }
        Course::create($d);
        return ['ok' => true, 'msg' => 'Course created.'];
    }

    public static function deleteCourse(int $id): array {
        Course::delete($id);
        return ['ok' => true, 'msg' => 'Course deleted.'];
    }
}
