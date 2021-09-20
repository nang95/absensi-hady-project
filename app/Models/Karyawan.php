<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function jabatan(){
        return $this->belongsTo(Jabatan::class);
    }
    
    public function absensi(){
        return $this->hasMany(Absensi::class);
    }
    
    public function cuti(){
        return $this->hasMany(Cuti::class);
    }

    public function izin(){
        return $this->hasMany(Izin::class);
    }

    public function pengajuan(){
        return $this->hasMany(Pengajuan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
