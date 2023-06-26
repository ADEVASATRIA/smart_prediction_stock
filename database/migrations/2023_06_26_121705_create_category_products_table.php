<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductsTable extends Migration
{
    public function up()
    {
        Schema::create('category_products', function (Blueprint $table) {
            $table->bigIncrements('id_category_product');
            $table->string('name_category_product');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_products');
    }
}
