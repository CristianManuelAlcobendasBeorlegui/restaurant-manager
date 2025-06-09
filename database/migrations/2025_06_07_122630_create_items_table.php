<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->binary('image')->nullable(); // Para tipo blob
            $table->string('quantity_type');
            $table->integer('items_per_unit');
            $table->unsignedBigInteger('category_id');
            $table->text('description')->nullable();
            $table->json('allergens')->nullable();
            $table->boolean('has_supplement')->default(false);
            $table->decimal('supplement_price', 8, 2)->default(0.0);
            $table->timestamps();

            $table
                ->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};
