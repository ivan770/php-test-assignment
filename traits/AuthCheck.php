<?php

namespace Traits;

use Models\Users;

trait AuthCheck
{
    public static function checkKey($key)
    {
        if (empty(Users::validate($_POST['key']))) {
            http_response_code(400);
            echo json_encode(['error' => true, 'errors' => 'Auth required!']);
            die();
        }
    }
}
