<?php
class AuthController {
    public static function login(string $email, string $password): bool {
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) return false;
        $_SESSION['user'] = [
            'id'   => $user['id'],
            'name' => $user['name'],
            'email'=> $user['email'],
            'role' => $user['role'],
        ];
        return true;
    }

    public static function register(string $name, string $email, string $password): array {
        if (strlen($name) < 2)          return ['ok' => false, 'msg' => 'Name too short.'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return ['ok' => false, 'msg' => 'Invalid email.'];
        if (strlen($password) < 6)      return ['ok' => false, 'msg' => 'Password min 6 chars.'];
        if (User::findByEmail($email))  return ['ok' => false, 'msg' => 'Email already registered.'];
        $id = User::create($name, $email, $password);
        $user = User::findById($id);
        $_SESSION['user'] = ['id'=>$user['id'],'name'=>$user['name'],'email'=>$user['email'],'role'=>$user['role']];
        return ['ok' => true];
    }

    public static function logout(): void {
        session_destroy();
    }
}
