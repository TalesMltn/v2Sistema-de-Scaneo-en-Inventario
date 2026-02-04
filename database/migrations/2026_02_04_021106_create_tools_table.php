<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();                    // slug generado automáticamente
            $table->string('code')->unique()->nullable();        // código de barras o QR
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->enum('status', ['optimo', 'mantenimiento', 'dañado'])->default('optimo');
            $table->boolean('needs_maintenance')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};