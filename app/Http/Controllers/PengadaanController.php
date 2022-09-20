<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.admin.pengadaan.index', [
            'title' => 'Pengadaan Barang',
            'pengadaan' => Pengadaan::search(request('search'))
                ->simplePaginate(10),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        Pengadaan::where('id', $id)
            ->update([
                'pengadaan_status_id' => 1,
            ]);

        return back()->with('msg', 'Berhasil Terima Permintaan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Pengadaan::where('id', $id)
            ->update([
                'description' => $request->description,
                'pengadaan_status_id' => 2,
            ]);

        return back()->with('msg', 'Berhasil Tolak Permintaan!');
    }
}
