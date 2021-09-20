<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Karyawan, Absensi};
use Session;
use App\Http\Requests\Kehadiran\UpdateRequest;

class KehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kehadiran = Absensi::where('tanggal', date('Y-m-d'))->orderBy('id', 'desc');
        $karyawan = Karyawan::whereNotIn('id', function($query){
            $query->select('karyawan_id')->from('absensis')
                                         ->where('tanggal', date('Y-m-d'));
        })->get();

        // jika ada data karyawan yang belum ada didata absensi/kehadiran pada tanggal hari ini
        if (count($karyawan) > 0) {
            foreach ($karyawan as $key => $item) {
                $kehadiran = Absensi::create([
                    'tanggal' => date('Y-m-d'),
                    'karyawan_id' => $item->id,
                    'jam_masuk' => null,
                    'keterangan' => null,
                    'status' => 'Belum/Tidak Hadir',
                ]);
            }
        }
        
        $q_nama = $request->nama;

        if (!empty($q_nama)) {
            $kehadiran->whereHas('pegawai', function($query){
                $query->where('nama', 'LIKE', '%'.$q_nama.'%');
            });
        }
        
        $kehadiran = $kehadiran->paginate(20);
        $skipped = ($kehadiran->perPage() * $kehadiran->currentPage()) - $kehadiran->perPage();

        return view('apps.admin.kehadiran.index')->with('kehadiran', $kehadiran)
                                                 ->with('skipped', $skipped)
                                                 ->with('q_nama', $q_nama);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Absensi $absensi)
    {
        $karyawan = Karyawan::orderBy('nama', 'asc')->get();
        return view('apps.admin.kehadiran.edit')->with('absensi', $absensi)
                                               ->with('karyawan', $karyawan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        $kehadiran = Absensi::findOrFail($request->id);

        $kehadiran->update($request->all());

        Session::flash('flash_message', 'Data telah diubah');
        return redirect()->route('admin.kehadiran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $kehadiran = Absensi::findOrFail($request->id);
        
        $kehadiran->delete();

        return redirect()->back();
    }
}
