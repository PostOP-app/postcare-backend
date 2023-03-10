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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->string('image')->nullable();
            // $table->enum('from', ['patient', 'med_provider']);
            // $table->enum('to', ['med_provider', 'patient']);
            $table->foreignId('from_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('to_id')->constrained('users')->onDelete('cascade');
            $table->boolean('read')->default(false);
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
        Schema::dropIfExists('messages');
    }
};
