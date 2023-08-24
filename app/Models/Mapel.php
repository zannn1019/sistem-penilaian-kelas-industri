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
    // public function Pengajar()
    // {
    //     return $this->hasMany(Pengajar::class);
    // }
}
