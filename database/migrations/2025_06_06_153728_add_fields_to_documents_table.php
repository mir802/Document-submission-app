<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('title')->after('user_id'); // Add 'title' as a string
            $table->json('principal_investigator')->nullable()->after('title'); // Add 'principal_investigator' as JSON
            $table->json('cv_paths')->nullable()->after('document_path'); // Add 'cv_paths' as JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['title', 'principal_investigator', 'cv_paths']); // Drop the added fields
        });
    }
};