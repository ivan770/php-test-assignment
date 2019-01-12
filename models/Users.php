<?php

namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Users extends Eloquent

{
    protected $fillable = [
        'name', 'email', 'password', 'key'
    ];

    protected $hidden = [
        'password'
    ];

    public static function register($name, $email, $password)
    {
        $user = Users::firstOrCreate(['email' => strip_tags($email)], ['name' => strip_tags($name), 'password' => password_hash($password, PASSWORD_DEFAULT), 'key' => uniqid(null, true)]);
        return $user;
    }

    public static function login($email)
    {
        $user = Users::where(['email' => strip_tags($email)])->first();
        return $user;
    }

    public static function validate($key)
    {
        $user = Users::where(['key' => strip_tags($key)])->first();
        return $user;
    }
}