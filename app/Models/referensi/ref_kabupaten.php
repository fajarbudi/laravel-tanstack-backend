<?php

namespace App\Models\referensi;

use Illuminate\Database\Eloquent\Model;

class ref_kabupaten extends Model
{
    protected $primaryKey = 'kabupaten_id';

    protected $fillable = [
        'kabupaten_nama'
    ];
}
