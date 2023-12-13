<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "kegiatan";

    public function kehadiran()
    {
        return $this->belongsTo(Kehadiran::class, 'id_kehadiran');
    }
}
