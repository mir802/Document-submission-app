<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('documents', function (Blueprint $table) {
        $table->foreignId('reviewer_id')->nullable()->constrained('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('documents', function (Blueprint $table) {
        $table->dropForeign(['reviewer_id']);
        $table->dropColumn('reviewer_id');
    });
}
};
