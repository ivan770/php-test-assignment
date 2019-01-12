<?php

namespace Database;

require "../bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('items', function ($table) {
    $table->increments('id');
    $table->string('name');
    $table->text('description');
    $table->string('barcode');
    $table->decimal('price', 6, 2); // Хранит в себе цену до 9999.99
    $table->timestamps();
});