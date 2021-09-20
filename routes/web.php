<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('auth')->group(function(){
    Route::get('/', function(){})->middleware('checkUserLevel');
    
    Route::prefix('/admin')->namespace('Admin')->name('admin.')->group(function(){
        Route::get('/','DashboardController@index')->name('/');
        Route::get('dashboard','DashboardController@index')->name('dashboard');
    
        Route::get('jabatan', 'JabatanController@index')->name('jabatan');
        Route::get('jabatan/create', 'JabatanController@create')->name('jabatan.create');
        Route::post('jabatan', 'JabatanController@store')->name('jabatan.store');
        Route::get('jabatan/edit/{jabatan}', 'JabatanController@edit')->name('jabatan.edit');
        Route::put('jabatan', 'JabatanController@update')->name('jabatan.update');
        Route::delete('jabatan', 'JabatanController@delete')->name('jabatan.delete');
    
        Route::get('karyawan', 'KaryawanController@index')->name('karyawan');
        Route::get('karyawan/create', 'KaryawanController@create')->name('karyawan.create');
        Route::post('karyawan', 'KaryawanController@store')->name('karyawan.store');
        Route::get('karyawan/edit/{karyawan}', 'KaryawanController@edit')->name('karyawan.edit');
        Route::put('karyawan', 'KaryawanController@update')->name('karyawan.update');
        Route::delete('karyawan', 'KaryawanController@delete')->name('karyawan.delete');
    
        Route::get('kehadiran', 'KehadiranController@index')->name('kehadiran');
        Route::get('kehadiran/generate-hari-libur', 'KehadiranController@generateHariLibur')->name('kehadiran.generate-hari-libur');
        Route::get('kehadiran/edit/{absensi}', 'KehadiranController@edit')->name('kehadiran.edit');
        Route::put('kehadiran', 'KehadiranController@update')->name('kehadiran.update');
        Route::delete('kehadiran', 'KehadiranController@delete')->name('kehadiran.delete');
        
        Route::get('cuti', 'CutiController@index')->name('cuti');
        Route::get('cuti/create', 'CutiController@create')->name('cuti.create');
        Route::post('cuti', 'CutiController@store')->name('cuti.store');
        Route::get('cuti/edit/{cuti}', 'CutiController@edit')->name('cuti.edit');
        Route::put('cuti', 'CutiController@update')->name('cuti.update');
        Route::delete('cuti', 'CutiController@delete')->name('cuti.delete');
        Route::get('cuti/cetak', 'CutiController@cetak')->name('cuti.cetak');
    
        Route::get('izin', 'IzinController@index')->name('izin');
        Route::get('izin/create', 'IzinController@create')->name('izin.create');
        Route::post('izin', 'IzinController@store')->name('izin.store');
        Route::get('izin/edit/{izin}', 'IzinController@edit')->name('izin.edit');
        Route::put('izin', 'IzinController@update')->name('izin.update');
        Route::delete('izin', 'IzinController@delete')->name('izin.delete');
        Route::get('izin/cetak', 'IzinController@cetak')->name('izin.cetak');
    
        Route::get('pengajuan_cuti', 'PengajuanCutiController@index')->name('pengajuan_cuti');
        Route::get('pengajuan_cuti/approve/{pengajuan}', 'PengajuanCutiController@approve')->name('pengajuan_cuti.approve');
        Route::delete('pengajuan_cuti', 'PengajuanCutiController@delete')->name('pengajuan_cuti.delete');
    
        Route::get('pengajuan_izin', 'PengajuanIzinController@index')->name('pengajuan_izin');
        Route::get('pengajuan_izin/approve/{pengajuan}', 'PengajuanIzinController@approve')->name('pengajuan_izin.approve');
        Route::delete('pengajuan_izin', 'PengajuanIzinController@delete')->name('pengajuan_izin.delete');
    
        Route::get('kantor', 'KantorController@index')->name('kantor');
        Route::put('kantor', 'KantorController@update')->name('kantor.update');

        Route::get('generate-hari-libur', 'GenerateHariLiburController@index')->name('generate-hari-libur');
        Route::post('generate-hari-libur', 'GenerateHariLiburController@store')->name('generate-hari-libur.store');
    
        Route::get('rekap-kehadiran', 'RekapKehadiranController@index')->name('rekap-kehadiran');
        Route::get('rekap-kehadiran/cetak-semua/{jangka}/{periode}', 'RekapKehadiranController@cetakSemua')->name('rekap-kehadiran.cetak-semua');    
        Route::get('rekap-kehadiran/cetak/{karyawan}/{jangka}/{periode}', 'RekapKehadiranController@cetak')->name('rekap-kehadiran.cetak');    

        Route::get('modul', 'ModulController@index')->name('modul');
        Route::get('modul/create', 'ModulController@create')->name('modul.create');
        Route::post('modul', 'ModulController@store')->name('modul.store');
        Route::get('modul/edit/{modul}', 'ModulController@edit')->name('modul.edit');
        Route::put('modul', 'ModulController@update')->name('modul.update');
        Route::delete('modul', 'ModulController@delete')->name('modul.delete');
    });
    
    Route::prefix('/pegawai')->namespace('Pegawai')->name('pegawai.')->group(function(){
        Route::get('/','DashboardController@index')->name('/');
        Route::get('dashboard','DashboardController@index')->name('dashboard');    
        
        Route::post('absen/checkin','KehadiranController@checkin')->name('absen.checkin');    
        Route::post('absen/checkout','KehadiranController@checkout')->name('absen.checkout');    
        Route::get('log_kehadiran','LogKehadiranController@index')->name('log-kehadiran');

        Route::get('pengajuan-cuti', 'PengajuanCutiController@index')->name('pengajuan-cuti');
        Route::get('pengajuan-cuti/create', 'PengajuanCutiController@create')->name('pengajuan-cuti.create');
        Route::post('pengajuan-cuti', 'PengajuanCutiController@store')->name('pengajuan-cuti.store');
        Route::get('pengajuan-cuti/edit/{pengajuan}', 'PengajuanCutiController@edit')->name('pengajuan-cuti.edit');
        Route::put('pengajuan-cuti', 'PengajuanCutiController@update')->name('pengajuan-cuti.update');
        Route::delete('pengajuan-cuti', 'PengajuanCutiController@delete')->name('pengajuan-cuti.delete');

        Route::get('pengajuan-izin', 'PengajuanIzinController@index')->name('pengajuan-izin');
        Route::get('pengajuan-izin/create', 'PengajuanIzinController@create')->name('pengajuan-izin.create');
        Route::post('pengajuan-izin', 'PengajuanIzinController@store')->name('pengajuan-izin.store');
        Route::get('pengajuan-izin/edit/{pengajuan}', 'PengajuanIzinController@edit')->name('pengajuan-izin.edit');
        Route::put('pengajuan-izin', 'PengajuanIzinController@update')->name('pengajuan-izin.update');
        Route::delete('pengajuan-izin', 'PengajuanIzinController@delete')->name('pengajuan-izin.delete');
    });
});