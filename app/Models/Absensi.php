<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function karyawan(){
        return $this->belongsTo(Karyawan::class);
    }

    public function getStatus($status){
        switch ($status) {
            case 'Belum/Tidak Hadir':
                return 'badge-danger';
                break;
            case 'Hadir':
                return 'badge-success';
                break;
            case 'Izin':
                return 'badge-primary';
                break;
            case 'Sakit':
                return 'badge-warning';
                break;
            default:
                return 'badge-default';
                break;
        }
    }

    public function getPersentaseKehadiran($karyawan_id, $periode, $jangka){
        if ($periode == "Bulan") {
            $jumlah_absen = $this->whereMonth('tanggal', $jangka);
            $jumlah_libur = $this->whereMonth('tanggal', $jangka);
            $jumlah_total_kerja = 30;
        }else{
            $jumlah_absen = $this->whereYear('tanggal', $jangka);
            $jumlah_libur = $this->whereYear('tanggal', $jangka);
            $jumlah_total_kerja = 366;
        }

        $jumlah_libur = $jumlah_libur->where('status', 'Libur')
                                     ->where('karyawan_id', $karyawan_id)
                                     ->count();                            

        $jumlah_absen = $jumlah_absen->where('status', 'Hadir')
                                     ->where('karyawan_id', $karyawan_id)
                                     ->count();

        $jumlah_total_kerja -= $jumlah_libur;
        $persentase_kehadiran = ($jumlah_absen / $jumlah_total_kerja) * 100;

        return round($persentase_kehadiran);
    }

    public function getJumlahLibur($karyawan_id, $periode, $jangka){
        if ($periode == "Bulan") {
            $jumlah_libur = $this->whereMonth('tanggal', $jangka)
                                 ->where('status', 'Libur')
                                 ->where('karyawan_id', $karyawan_id)
                                 ->count();
        }else{
            $jumlah_libur = $this->whereYear('tanggal', $jangka)
                                 ->where('status', 'Libur')
                                 ->where('karyawan_id', $karyawan_id)
                                 ->count();
        }

        return $jumlah_libur;
    }

    public function getJumlahIzin($karyawan_id, $periode, $jangka){
        if ($periode == "Bulan") {
            $jumlah_izin = $this->whereMonth('tanggal', $jangka)
                                 ->where('status', 'Izin')
                                 ->where('karyawan_id', $karyawan_id)
                                 ->count();
        }else{
            $jumlah_izin = $this->whereYear('tanggal', $jangka)
                                 ->where('status', 'Izin')
                                 ->where('karyawan_id', $karyawan_id)
                                 ->count();
        }

        return $jumlah_izin;
    }

    public function getJumlahCuti($karyawan_id, $periode, $jangka){
        if ($periode == "Bulan") {
            $jumlah_cuti = $this->whereMonth('tanggal', $jangka)
                                 ->where('status', 'Cuti')
                                 ->where('karyawan_id', $karyawan_id)
                                 ->count();
        }else{
            $jumlah_cuti = $this->whereYear('tanggal', $jangka)
                                 ->where('status', 'Cuti')
                                 ->where('karyawan_id', $karyawan_id)
                                 ->count();
        }

        return $jumlah_cuti;
    }
}
