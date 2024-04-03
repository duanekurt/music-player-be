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
        Schema::create('playlist_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playlist_id')->nullable();
            $table->unsignedBigInteger('song_id')->nullable();
            $table->integer('status')->comment('1 = finished 0 = skipped');

            $table->timestamps();

            $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('set null');
            $table->foreign('song_id')->references('id')->on('songs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_histories');
    }
};
