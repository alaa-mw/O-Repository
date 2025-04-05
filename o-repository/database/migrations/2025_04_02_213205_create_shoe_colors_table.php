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
        Schema::create('shoe_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shoe_id');
            $table->foreign('shoe_id')->references('id')->on('shoes')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('avaliable_amount')->default(0);
            $table->unsignedBigInteger('sold_amount')->default(0);
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoe_colors');
    }
};
