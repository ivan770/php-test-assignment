<?php

// require __DIR__ . "/../../bootstrap.php";

namespace Controllers\Auth;

use Models\Users;

class authController
{
    public function login()
    {
        $v = new \Valitron\Validator($_POST);
        $v->rule('required', ['email', 'password']);
        $v->rule('lengthMax', ['email'], 255);
        $v->rule('email', 'email');
        if (!$v->validate()) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => $v->errors()]);
            die();
        }

        // Получаем пользователя по почте
        $user = Users::login($_POST['email']);
        if (empty($user)) {
            http_response_code(404);
            echo json_encode(['error' => true, 'errors' => 'User not found']);
            die();
        }

        // Проверяем пароль
        if (!password_verify($_POST['password'], $user->password)) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => 'Incorrect password']);
            die();
        }

        echo json_encode(['error' => false, 'id' => $user->id, 'key' => $user->key]); // 👌
    }

    public function register()
    {
        $v = new \Valitron\Validator($_POST);
        $v->rule('required', ['name', 'email', 'password']);
        $v->rule('lengthMax', ['name', 'email'], 255);
        $v->rule('email', 'email');
        if (!$v->validate()) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => $v->errors()]);
            die();
        }

        // Вызываем метод модели для создания пользователя. Генерируем его ключ доступа на основе текущего времени с повышенной энтропией.
        $user = Users::register($_POST['name'], $_POST['email'], $_POST['password']);

        echo json_encode(['error' => !$user->wasRecentlyCreated, 'id' => $user->id]); // 👌
    }
}
