<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.admin.department.index', [
            'title' => 'List Bidang',
            'departments' => Department::search(request('search'))->simplePaginate(10),
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
        Department::create([
            'department' => $request->department_create,
        ]);

        return back()->with('msg', 'Berhasil Tambah Data Bidang!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        Department::where('id', $department->id)->update([
            'department' => $request->department_edit,
        ]);

        return back()->with('msg', 'Berhasil Ubah Data Bidang!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->destroy($department->id);

        return back()->with('msg', 'Berhasil Hapus Data Bidang!');
    }
}
