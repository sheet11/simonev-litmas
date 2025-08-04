<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'role')) { // TAMBAHKAN PENGECEKAN INI
            $table->string('role')->default('ketua_pelaksana')->after('email');
        }
    });
}

}; // <--- TAMBAHKAN INI di baris terakhir!
