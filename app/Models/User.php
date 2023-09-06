<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Prompts\Key;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName("user");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
    protected $with = ['sekolah', 'mapel', 'kelas'];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'pengajar_sekolah', 'id_user', 'id_kelas')->withTimestamps();
    }
    public function mapel()
    {
        return $this->belongsToMany(Mapel::class, 'pengajar_mapel', 'id_user', 'id_mapel')->withTimestamps();
    }
    public function sekolah()
    {
        return $this->belongsToMany(Sekolah::class, 'pengajar_sekolah', 'id_user', 'id_sekolah')->withTimestamps();
    }
}
