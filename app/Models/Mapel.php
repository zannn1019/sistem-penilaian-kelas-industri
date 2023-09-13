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
    // protected $with = ['tugas'];
    public function pengajar()
    {
        return $this->belongsToMany(User::class, 'pengajar_mapel', 'id_mapel', 'id_user');
    }
    public function tugas()
    {
        return $this->hasManyThrough(
            Tugas::class,
            PengajarMapel::class,
            'id_mapel',
            'id_pengajar',
            'id',
            'id'
        );
    }
}
