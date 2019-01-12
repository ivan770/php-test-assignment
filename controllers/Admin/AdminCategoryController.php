<?php

// require __DIR__ . "/../../bootstrap.php";

namespace Controllers\Admin;

use Models\Categories;
use Traits\AuthCheck;

class AdminCategoryController
{
    public function key()
    {
        AuthCheck::checkKey($_POST['key']);
    }

    public function addCategory()
    {
        self::key();
        $v = new \Valitron\Validator($_POST);
        $v->rule('required', 'category');
        $v->rule('lengthMax', 'category', 255);
        if (!$v->validate()) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => $v->errors()]);
            die();
        }

        // Создаём категорию
        $category = Categories::add(strip_tags($_POST['category']));

        echo json_encode(['error' => false, 'id' => $category->id]); // 👌
    }

    public function removeCategory()
    {
        self::key();
        $v = new \Valitron\Validator($_POST);
        $v->rule('required', 'id');
        if (!$v->validate()) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => $v->errors()]);
            die();
        }

        // Проверяем существование категории
        try {
            $category = Categories::where(['id' => $_POST['id']])->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => 'Category not found']);
            die();
        }

        // Разрываем взаимоотношения и удаляем категорию
        $category->items()->detach();
        $category->remove($_POST['id']);

        echo json_encode(['error' => false]); // 👌
    }
}
