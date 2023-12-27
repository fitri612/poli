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
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_poli_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('date_checkup');
            $table->text('note');
            $table->decimal('amount', 20, 2)->default(0);
            $table->decimal('total_payment', 20, 2)->default(0);
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
        Schema::dropIfExists('checkups');
    }
};
