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
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('viewport')->nullable();
            $table->string('robots')->nullable();
            $table->string('charset')->nullable();
            $table->integer("totalTile")->nullable();
            $table->integer("totalDescription")->nullable();
            $table->boolean("httpEquivRefreshPresent")->nullable();
            $table->bigInteger("webpageId");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata');
    }
};
