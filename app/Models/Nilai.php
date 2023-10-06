<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use NumberToWords\NumberToWords;

class Nilai extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'id'
    ];
    protected $table = 'nilai';
    protected $dates = ['deleted_at'];
    protected $with = ['tugas', 'siswa'];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas');
    }

    public function getHurufNilai(int $nilai)
    {
        return NumberToWords::transformNumber('id', $nilai);
    }
}
