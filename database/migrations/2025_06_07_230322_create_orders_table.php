<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('table_id');
            $table->enum('status', [
                'ordering',
                'waiting-for-validation',
                'denied',
                'in-queue',
                'preparing',
                'completed',
            ]);
            $table->text('observations')->nullable();
            $table->timestamps();

            $table
                ->foreign('table_id')
                ->references('id')
                ->on('tables')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
