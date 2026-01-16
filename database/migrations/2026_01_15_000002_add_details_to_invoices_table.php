<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('to_client')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
        });

        Schema::create('invoice_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->text('term_text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_terms');
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['to_client', 'subject', 'description']);
        });
    }
};
