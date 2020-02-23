<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->enum('category', ['WOMENOPTICAL', 'MENOPTICAL', 'KIDSOPTICAL', 'KIDSSUNGLASSES', 'MENSUNGLASSES', 'WOMENSUNGLASSES']);
            $table->string('sku', 60);
            $table->string('name', 50);
            $table->string('description', 100);
            $table->integer('qty')->default(100);
            $table->decimal('price', 10, 2);
            $table->string('details', 3000)->nullable();
            $table->string('image', 500);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
