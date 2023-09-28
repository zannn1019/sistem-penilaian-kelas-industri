<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nilai extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'id'
    ];
    protected $table = 'nilai';
    protected $dates = ['deleted_at'];
    protected $with = ['tugas'];
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas');
    }
}
