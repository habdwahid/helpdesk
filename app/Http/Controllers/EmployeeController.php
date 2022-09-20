<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gender;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Department;
use App\Models\UserRole;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main.admin.employee.index', [
            'title' => 'List Pegawai',
            'departments' => Department::all(),
            'genders' => Gender::all(),
            'employees' => Employee::search(request('search'))->simplePaginate(10),
            'positions' => Position::all(),
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
            'nip' => $request->nip_add,
            'name' => $request->name_add,
            'email' => Str::lower($request->email_add),
            'password' => bcrypt($request->password_add),
        ]);

        UserRole::create([
            'role_id' => 3,
            'user_id' => $user->id,
        ]);

        Employee::create([
            'user_id' => $user->id,
            'position_id' => $request->position_add,
            'sub_department_id' => $request->sub_department_add,
            'gender_id' => $request->gender_add,
        ]);

        event(new Registered($user));

        return back()->with('msg', 'Berhasil Tambah Data Pegawai');
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
        User::where('id', $id)
            ->update([
                'nip' => $request->nip_edit,
                'name' => $request->name_edit,
                'email' => Str::lower($request->email_edit),
            ]);

        if ($request->password_edit !== null) {
            User::where('id', $id)->update([
                'password' => $request->password_edit,
            ]);
        }

        Employee::where('user_id', $id)->update([
            'position_id' => $request->position_edit,
            'sub_department_id' => $request->sub_department_edit,
            'gender_id' => $request->gender_edit,
        ]);

        return back()->with('msg', 'Berhasil Ubah Data Pegawai');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::where('user_id', $id)->delete();

        UserRole::where('user_id', $id)->delete();

        User::destroy($id);

        return back()->with('msg', 'Berhasil Hapus Data Pegawai!');
    }
}
