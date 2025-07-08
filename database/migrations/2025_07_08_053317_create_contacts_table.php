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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reception_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('text');
            $table->string('sender'); // email sender nya ya bang
            $table->string('answer_title')->nullable();
            $table->text('answer_text')->nullable();
            $table->enum('situation', ['answered', 'unanswered'])->default('unanswered');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
