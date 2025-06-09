<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('connected_users', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('table_code');
            $table->boolean('is_admin')->default(false);

            $table->timestamps();

            $table
                ->foreign('table_code')
                ->references('code')
                ->on('tables')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('connected_users');
    }
};
