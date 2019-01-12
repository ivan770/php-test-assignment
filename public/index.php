<?php
require "../bootstrap.php";

// Создаём объект роутера
$router = new AltoRouter();

$router->map('GET', '/categories/getAll', function() {
    \Controllers\Categories\CategoriesController::getAll();
});

$router->map('POST', '/items/getByCat', function() {
    \Controllers\Items\ItemsController::getByCat();
});

$router->map('POST', '/auth/login', function() {
    \Controllers\Auth\AuthController::login();
});

$router->map('POST', '/auth/register', function() {
    \Controllers\Auth\AuthController::register();
});

$router->map('POST', '/admin/addCategory', function() {
    \Controllers\Admin\AdminCategoryController::addCategory();
});

$router->map('POST', '/admin/removeCategory', function() {
    \Controllers\Admin\AdminCategoryController::removeCategory();
});

$router->map('POST', '/admin/addItem', function() {
    \Controllers\Admin\AdminItemController::addItem();
});

$router->map('POST', '/admin/removeItem', function() {
    \Controllers\Admin\AdminItemController::removeItem();
});

$match = $router->match();

// Проверяем на совпадение ссылки
if( $match && is_callable( $match['target'] ) ) {
    // Вызываем анонимную функцию
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// Ничего не найдено, выдаём 404
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}