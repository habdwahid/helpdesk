<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.admin.position.index', [
            'title' => 'Jabatan',
            'positions' => Position::search(request('search'))->simplePaginate(10),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Position::create([
            'position' => $request->position_create,
        ]);

        return back()->with('msg', 'Berhasil Tambah Data Pegawai!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        Position::where('id', $position->id)->update([
            'position' => $request->position_edit,
        ]);

        return back()->with('msg', 'Berhasil Ubah Data Jabatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $position->destroy($position->id);

        return back()->with('msg', 'Berhasil Hapus Data Jabatan!');
    }
}
