<?php

// require __DIR__ . "/../../bootstrap.php";

namespace Controllers\Admin;

use Models\Categories;
use Models\Items;
use Traits\AuthCheck;

class AdminItemController
{
    public function key()
    {
        AuthCheck::checkKey($_POST['key']);
    }

    public function addItem()
    {
        self::key();

        $v = new \Valitron\Validator($_POST);
        $v->rule('required', ['name', 'description', 'barcode', 'price', 'category']);
        $v->rule('lengthMax', ['name', 'barcode'], 255);
        $v->rule('lengthMax', 'description', 65535);
        $v->rule('numeric', ['price', 'category']);
        $v->rule('max', 'price', 9999.99);
        if (!$v->validate()) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => $v->errors()]);
            die();
        }

        // Проверяем существование категории
        try {
            $category = Categories::findOrFail($_POST['category']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => 'Category not found']);
            die();
        }

        // Вызываем метод модели для создания товара и синхронизируем взаимоотношения между моделями
        $item = Items::add(strip_tags($_POST['name']), strip_tags($_POST['description']), strip_tags($_POST['barcode']), $_POST['price']);
        $category->items()->syncWithoutDetaching([$item->id]);

        echo json_encode(['error' => false, 'id' => $item->id]); // 👌
    }

    public function removeItem()
    {
        self::key();

        $v = new \Valitron\Validator($_POST);
        $v->rule('required', 'id');
        if (!$v->validate()) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => $v->errors()]);
            die();
        }

        // Проверяем существование товара
        try {
            $item = Items::where(['id' => $_POST['id']])->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => 'Item not found']);
            die();
        }

        // Разрываем взаимоотношения и удаляем товар
        $item->categories()->detach();
        $item->remove($_POST['id']);

        echo json_encode(['error' => false]); // 👌
    }
}
