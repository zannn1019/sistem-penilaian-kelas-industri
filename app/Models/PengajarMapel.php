<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajarMapel extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    protected $cascadeDeletes = ['tugas'];
    protected $table = 'pengajar_mapel';
    protected $dates = ['deleted_at'];
    protected $with = "mapel";
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'id_pengajar');
    }
}
