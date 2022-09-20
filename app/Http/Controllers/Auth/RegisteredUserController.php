<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Gender;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SubDepartment;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    public function index()
    {
        return view('main.employee.index', [
            'title' => 'List Pegawai',
            'departments' => Department::all(),
            'genders' => Gender::all(),
            'users' => User::with(['gender', 'position', 'sub_department'])->get(),
            'positions' => Position::all(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'position' => ['required'],
            'sub_department' => ['required'],
            'gender' => ['required'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => Str::lower($request->email),
            'position_id' => $request->position,
            'sub_department_id' => $request->sub_department,
            'gender_id' => $request->gender,
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($user));

        return back()->with('msg', 'Berhasil Tambah Data Pegawai');
    }

    public function edit(User $user, $id)
    {
        return view('main.employee.edit', [
            'title' => 'Ubah Data Pegawai',
            'departments' => Department::all(),
            'genders' => Gender::all(),
            'positions' => Position::all(),
            'sub_departments' => SubDepartment::all(),
            'user' => $user->where('id', $id)->with(['position', 'sub_department', 'gender'])->first(),
        ]);
    }

    public function update(User $user, Request $request, $id)
    {
        $user->where('id', $id)->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'position_id' => $request->position,
            'gender_id' => $request->gender,
            'sub_department_id' => $request->sub_department,
        ]);

        return back()->with('msg', 'Berhasil Ubah Data Pegawai!');
    }

    public function destroy(User $user, $id)
    {
        $user->destroy($id);

        return back()->with('msg', 'Berhasil Hapus Data Pegawai!');
    }
}
