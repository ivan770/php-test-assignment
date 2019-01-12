<?php

// require __DIR__ . "/../../bootstrap.php";

namespace Controllers\Categories;

use Models\Categories;

class categoriesController
{
    public function getAll()
    {
        $categories = Categories::get();
        echo json_encode(['error' => false, 'categories' => $categories]); // 👌
    }
}
