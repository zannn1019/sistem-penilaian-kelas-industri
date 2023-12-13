<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Clockwork\Request\Request;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Laravel\Prompts\Key;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable, CascadeSoftDeletes;

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
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
    protected $cascadeDeletes = ['kelas', 'mapel', 'sekolah'];

    public function tugas()
    {
        return $this->hasManyThrough(
            Tugas::class,
            PengajarMapel::class,
            'id_user',
            'id_pengajar',
            'id',
            'id'
        );
    }
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
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }

    public function toSearchableArray()
    {
        return [
            'nama' => $this->nama
        ];
    }
    public function scopeFilter($query, array $filters)
    {
        if ($filters['status'] == "online") {
            $onlineUsers = [];
            $users = $query->get();
            foreach ($users as $user) {
                $isOnline = Cache::has('is_online' . $user->id_user);
                if ($isOnline) {
                    $onlineUsers[] = $user->id_user;
                }
            }
            $query->whereIn('id_user', $onlineUsers);
        } else {
            $query->when(
                $filters['status'] ?? null,
                fn ($query, $filter) =>
                $query->where('status', $filter)
            );
        }

        if ($filters['sort'] == 'edited') {
            $query->orderBy("updated_at", "DESC");
        } else {
            $query->when(
                $filters['sort'] ?? null,
                fn ($query, $filter) =>
                $query->orderBy('nama', $filter)
            );
        }
    }
}
