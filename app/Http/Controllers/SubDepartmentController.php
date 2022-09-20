<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Http\Request;

class SubDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.admin.sub-department.index', [
            'title' => 'Sub Bidang',
            'departments' => Department::all(),
            'sub_departments' => SubDepartment::search(request('search'))
                ->simplePaginate(10),
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
        if (empty($request->newDept)) {
            SubDepartment::create([
                'department_id' => $request->department_create,
                'sub_department' => $request->sub_department_create,
            ]);
        } else {
            $department = Department::create([
                'department' => $request->newDept,
            ]);

            SubDepartment::create([
                'department_id' => $department->id,
                'sub_department' => $request->sub_department_create,
            ]);
        }

        return back()->with('msg', 'Berhasil Tambah Data Sub Bidang!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubDepartment  $subDepartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubDepartment $subDepartment)
    {
        SubDepartment::where('id', $subDepartment->id)->update([
            'sub_department' => $request->sub_department_edit,
        ]);

        return back()->with('msg', 'Berhasil Ubah Data Sub Bidang!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubDepartment  $subDepartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubDepartment $subDepartment)
    {
        $subDepartment->destroy($subDepartment->id);

        return back()->with('msg', 'Berhasil Hapus Data Sub Bidang!');
    }
}
