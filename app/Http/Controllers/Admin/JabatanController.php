<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan;
use Session;
use App\Http\Requests\Jabatan\{CreateRequest, UpdateRequest};

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jabatan = Jabatan::orderBy('nama', 'asc');
        $q_nama = $request->q_nama;

        if (!empty($q_nama)) {
            $jabatan->where('nama', 'LIKE', '%'.$q_nama.'%');
        }
        
        $jabatan = $jabatan->paginate(20);
        $skipped = ($jabatan->perPage() * $jabatan->currentPage()) - $jabatan->perPage();

        return view('apps.admin.jabatan.index')->with('jabatan', $jabatan)
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
        return view('apps.admin.jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $jabatan = $request->all();
        Jabatan::create($jabatan);

        Session::flash('flash_message', 'Data telah disimpan');
        return redirect()->route('admin.jabatan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        return view('apps.admin.jabatan.edit')->with('jabatan', $jabatan);
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
        $jabatan = Jabatan::findOrFail($request->id);

        $jabatan->update($request->all());

        Session::flash('flash_message', 'Data telah diubah');
        return redirect()->route('admin.jabatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $jabatan = Jabatan::findOrFail($request->id);
        
        $jabatan->delete();

        return redirect()->back();
    }
}
