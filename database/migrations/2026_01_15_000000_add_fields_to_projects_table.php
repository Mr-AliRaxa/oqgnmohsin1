<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('name')->nullable()->after('company_id');
            $table->string('location')->nullable()->after('name');
            $table->text('description')->nullable()->after('subject');
            $table->string('owner_name')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['name', 'location', 'description', 'owner_name']);
        });
    }
};
