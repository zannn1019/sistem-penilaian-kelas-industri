<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "kehadiran";
    protected $with = ['kegiatan', 'user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_kehadiran');
    }
}
