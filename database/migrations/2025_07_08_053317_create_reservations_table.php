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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['application', 'confirmed', 'rejected'])->default('application');
            $table->enum('service', [
                'Installation of tires purchased at our store',
                'Replacement and installation of tires brought in (tires shipped directly to our store)',
                'Oil change',
                'Tire storage and tire replacement at our store',
                'Change tires by bringing your own (removal and removal of season tires, etc.)'
            ]);
            $table->datetime('datetime');
            $table->string('coupon_code')->nullable();
            $table->string('customer_contact')->nullable();
            $table->text('management_notes')->nullable();
            $table->text('simple_questionnaire')->nullable();
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
