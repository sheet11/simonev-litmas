<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('litmas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->year('tahun');
            $table->string('ketua');
            $table->string('prodi');
            $table->text('luaran_wajib')->nullable();
            $table->text('luaran_tambahan')->nullable();
            $table->enum('status', ['Belum Tercapai', 'Tercapai', 'Revisi', 'Ditolak'])->default('Belum Tercapai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('litmas');
    }
};
