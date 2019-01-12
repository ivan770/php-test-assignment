<?php

namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Categories extends Eloquent

{
    public $timestamps = false;

    protected $fillable = [
        'category'
    ];

    public static function add($category)
    {
        $category = Categories::create(['category' => $category]);
        return $category;
    }

    public static function remove($id)
    {
        $category = Categories::where(['id' => $id])->delete();
        return $category;
    }

    public function items()
    {
        return $this->belongsToMany(\Models\Items::class);
    }
}