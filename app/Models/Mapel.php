<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory, SoftDeletes, Searchable, CascadeSoftDeletes;
    protected $guarded = [
        'id'
    ];
    protected $cascadeDeletes = ['pengajar', 'tugas', 'nilai'];
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
    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['filter'] == 'a-z' ?? false,
            fn ($query) =>
            $query->orderBy('nama_mapel', 'ASC')
        );
        $query->when(
            $filters['filter'] == 'edited' ?? false,
            fn ($query) =>
            $query->orderBy('updated_at', 'DESC')
        );
        $query->when(
            $filters['filter'] == 'newest' ?? false,
            fn ($query) =>
            $query->orderBy('created_at', 'DESC')
        );
        $query->when(
            $filters['filter'] == 'oldest' ?? false,
            fn ($query) =>
            $query->orderBy('created_at', 'ASC')
        );
    }
}
