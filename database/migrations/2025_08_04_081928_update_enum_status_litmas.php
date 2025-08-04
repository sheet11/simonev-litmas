<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE litmas MODIFY status ENUM('Belum Tercapai', 'Menunggu Verifikasi', 'Tercapai', 'Revisi', 'Ditolak') NOT NULL DEFAULT 'Belum Tercapai'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE litmas MODIFY status ENUM('Belum Tercapai', 'Tercapai', 'Revisi', 'Ditolak') NOT NULL DEFAULT 'Belum Tercapai'");
    }
};
