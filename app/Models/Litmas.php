<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Litmas extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'tahun', 'ketua', 'prodi', 'luaran_wajib', 'luaran_tambahan', 'status',
    ];
}
