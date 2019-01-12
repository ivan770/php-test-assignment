<?php

// require __DIR__ . "/../../bootstrap.php";

namespace Controllers\Items;

use Models\Categories;

class itemsController
{
    public function getByCat()
    {
        $v = new \Valitron\Validator($_POST);
        $v->rule('required', 'category');
        if (!$v->validate()) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => $v->errors()]);
            die();
        }

        // Получаем категорию по ID, и забираем её вместе с предметами которые ей принадлежат
        $category = Categories::where('id', $_POST['category'])->with('items')->first();

        echo json_encode(['error' => empty($category->items), 'items' => $category->items]); // 👌
    }
}
