<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('co_investigators', function (Blueprint $table) {
                $table->id();
                $table->foreignId('document_id')->constrained()->onDelete('cascade');
                $table->string('full_name');
                $table->string('email');
                $table->string('specialization');
                $table->string('phone');
                $table->timestamps();
            });
    }

    public function down()
    {
        Schema::dropIfExists('co_investigators');
    }
};