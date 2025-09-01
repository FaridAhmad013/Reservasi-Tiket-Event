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
        Schema::create('detail_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('area');
            $table->text('deskripsi');
            $table->unsignedTinyInteger('jumlah_tiket');
            $table->string('status'); //tersedia, habis, ditutup
            $table->timestamp('dibuka_pada')->nullable();
            $table->timestamp('ditutup_pada')->nullable();
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_event');
    }
};
