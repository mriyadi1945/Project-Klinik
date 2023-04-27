<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antriansoal extends Model
{
    use HasFactory;
    protected $table = 'antriansoal';
    public $timestamps = false;
    protected $primaryKey = 'nomorkartu';

    protected $fillable = [
        'nomorkartu',
        'nomorantrean',
        'angkaantrean',
        'norm',
        'namapoli',
        'kodepoli',
        'tglpriksa',
        'nik',
        'keluhan',
        'statusdipanggil',
        'int'
    ];

    protected $casts = [
        'nomorkartu' => 'string',
        'int' => 'integer'
    ];
}
