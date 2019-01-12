<?php

namespace Database;

require "../bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('categories_items', function ($table) {
    $table->increments('id');
    $table->integer('categories_id')->unsigned()->index();
    $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade');
    $table->integer('items_id')->unsigned()->index();
    $table->foreign('items_id')->references('id')->on('items')->onDelete('cascade');
});