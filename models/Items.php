<?php

namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Items extends Eloquent
{
    protected $fillable = [
        'name', 'description', 'barcode', 'price',
    ];

    public static function add($name, $description, $barcode, $price)
    {
        $item = self::create(['name' => $name, 'description' => $description, 'barcode' => $barcode, 'price' => $price]);

        return $item;
    }

    public static function remove($id)
    {
        $item = self::where(['id' => $id])->delete();

        return $item;
    }

    public function categories()
    {
        return $this->belongsToMany(\Models\Categories::class);
    }
}
