<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kantor;
use Session;

class KantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kantor = Kantor::first();

        if ($kantor == null) {
            $kantor = Kantor::create([
                'name' => 'Example',
                'longitude' => '3.601482',
                'latitude' => '98.681120',
                'jarak_m' => '14'
            ]);
        }      
        
        return view('apps.admin.kantor.index')->with('kantor', $kantor);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $kantor = Kantor::findOrFail($request->id);
        
        $kantor->update($request->all());

        Session::flash('flash_message', 'Data telah diubah');
        return redirect()->back();
    }
}
