<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('item_id');
            $table
                ->enum('status', [
                    'ordering',
                    'waiting-for-validation',
                    'denied',
                    'in-queue',
                    'preparing',
                    'completed',
                    'in-queue',
                ])
                ->default('in-queue');
            $table->string('connected_user_code')->nullable();
            $table->timestamps();

            $table
                ->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table
                ->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
            $table
                ->foreign('connected_user_code')
                ->references('code')
                ->on('connected_users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
