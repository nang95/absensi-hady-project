<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modul;
use App\Http\Requests\Modul\{CreateRequest, UpdateRequest};
use Session;

class ModulController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modul = Modul::orderBy('id', 'desc');
        $q_nama = $request->nama;

        if (!empty($q_nama)) {
            $modul->where('name','LIKE','%'.$q_nama.'%');
        }
        
        $modul = $modul->paginate(20);
        $skipped = ($modul->perPage() * $modul->currentPage()) - $modul->perPage();

        return view('apps.admin.modul.index')->with('modul', $modul)
                                                 ->with('skipped', $skipped)
                                                 ->with('q_nama', $q_nama);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('apps.admin.modul.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $modul = $request->all();
        Modul::create($modul);

        Session::flash('flash_message', 'Data telah disimpan');
        return redirect()->route('admin.modul');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Modul $modul)
    {
        $karyawan = Karyawan::orderBy('nama', 'asc')->get();
        return view('apps.admin.modul.edit')->with('modul', $modul)
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
        $modul = Modul::findOrFail($request->id);

        $modul->update($request->all());

        Session::flash('flash_message', 'Data telah diubah');
        return redirect()->route('admin.modul');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $modul = Modul::findOrFail($request->id);
        
        $modul->delete();
        return redirect()->back();
    }
}
