<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('litmas', function (Blueprint $table) {
            $table->string('luaran_file')->nullable()->after('luaran_tambahan');
            $table->string('luaran_link')->nullable()->after('luaran_file');
        });
    }

    public function down()
    {
        Schema::table('litmas', function (Blueprint $table) {
            $table->dropColumn(['luaran_file', 'luaran_link']);
        });
    }
};
