<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Userr extends Authenticatable
{
    use Notifiable; // Tambahkan trait Notifiable jika Anda berencana untuk menggunakan notifikasi

    public $timestamps = false;

    protected $table = 'userr'; // Nama tabel
    protected $primaryKey = 'id_user'; // Kunci primer
    protected $fillable = ['nama_user', 'role', 'email', 'password', 'id_divisi']; // Menambahkan id_divisi

    const ROLE_ADMIN = 'admin';
    const ROLE_KADIV = 'kepala_divisi';

    public static function roles()
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_KADIV,
        ];
    }

    // Relasi ke Divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi'); // Menghubungkan dengan id_divisi di tabel divisi
    }

    // Jika Anda ingin menggunakan hashing untuk password, Anda dapat menambahkan mutator
    // public function setPasswordAttribute($password)
    // {
    //     $this->attributes['password'] = bcrypt($password);
    // }

    // Jika Anda ingin menambahkan aksesors untuk nama_user
    public function getNameAttribute()
    {
        return $this->attributes['nama_user'];
    }
}
