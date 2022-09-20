<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Gender;
use App\Models\Position;
use App\Models\Technician;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.admin.technician.index', [
            'departments' => Department::all(),
            'genders' => Gender::all(),
            'positions' => Position::all(),
            'title' => 'Teknisi',
            'technicians' => Technician::search(request('search'))->simplePaginate(10),
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
        $user = User::create([
            'nip' => $request->nip_create,
            'name' => $request->name_create,
            'email' => $request->email_create,
            'password' => bcrypt($request->password_create),
        ]);

        UserRole::create([
            'role_id' => 2,
            'user_id' => $user->id,
        ]);

        Technician::create([
            'user_id' => $user->id,
            'position_id' => $request->position_create,
            'sub_department_id' => $request->sub_department_create,
            'gender_id' => $request->gender_create,
            'technician_status_id' => 1,
        ]);

        return back()->with('msg', 'Berhasil Tambah Data Teknisi!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (empty($request->password_edit)) {
            User::where('id', $id)->update([
                'nip' => $request->nip_edit,
                'name' => $request->name_edit,
                'email' => $request->email_edit,
            ]);
        } else {
            User::where('id', $id)->update([
                'nip' => $request->nip_edit,
                'name' => $request->name_edit,
                'email' => $request->email_edit,
                'password' => bcrypt($request->password_edit),
            ]);
        }

        Technician::where('user_id', $id)->update([
            'gender_id' => $request->gender_edit,
            'position_id' => $request->position_edit,
            'sub_department_id' => $request->sub_department_edit,
        ]);

        return back()->with('msg', 'Berhasil Ubah Data Teknisi!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Technician::where('user_id', $id)->delete();

        UserRole::where('user_id', $id)->delete();

        User::destroy($id);

        return back()->with('msg', 'Berhasil Hapus Data Teknisi!');
    }
}
