<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Tugas extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    protected $with  = ['pengajar'];
    public function scopeTipe($query, array $filter)
    {
        $query->when($filter['tipe'] ?? false, function ($query, $filter) {
            $query->whereIn('tipe', $filter);
        });

        $query->when($filter['id_kelas'] ?? false, function ($query, $filter) {
            $query->where('id_kelas', $filter);
        });
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_tugas');
    }
    public function pengajar()
    {
        return $this->belongsTo(PengajarMapel::class, 'id_pengajar');
    }
}
