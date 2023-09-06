<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $table = 'mapel';
    public function pengajar()
    {
        return $this->belongsToMany(User::class, 'pengajar_mapel', 'id_mapel', 'id_user');
    }
}
