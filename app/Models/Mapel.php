<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory, SoftDeletes, Searchable;
    protected $guarded = [
        'id'
    ];
    protected $table = 'mapel';
    protected $dates = ['deleted_at'];
    protected $with = ['pengajar'];

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
    public function nilai()
    {
        return $this->hasManyThrough(
            Nilai::class,
            PengajarMapel::class,
            'id_mapel',
            'id',
            'id'
        );
    }
    public function toSearchableArray()
    {
        return [
            'nama_mapel' => $this->nama_mapel
        ];
    }
}
