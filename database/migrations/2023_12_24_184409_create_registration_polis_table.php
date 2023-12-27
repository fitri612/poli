<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_polis', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number');
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_schedule_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('complaint');
            $table->enum('status', ['waiting', 'called', 'done', 'canceled'])->default('waiting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration_polis');
    }
};
