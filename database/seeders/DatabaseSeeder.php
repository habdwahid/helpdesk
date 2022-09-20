<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Role
         */
        DB::table('roles')->insert([
            'role' => 'admin',
            'description' => 'Admin',
        ]);

        DB::table('roles')->insert([
            'role' => 'technician',
            'description' => 'Teknisi',
        ]);

        DB::table('roles')->insert([
            'role' => 'user',
            'description' => 'User',
        ]);

        DB::table('roles')->insert([
            'role' => 'manager',
            'description' => 'Manager',
        ]);

        /**
         * Gender
         */
        DB::table('genders')->insert([
            'gender' => 'Laki-Laki',
        ]);

        DB::table('genders')->insert([
            'gender' => 'Perempuan',
        ]);

        /**
         * Position
         */
        DB::table('positions')->insert([
            'position' => 'Kepala Divisi IT'
        ]);

        DB::table('positions')->insert([
            'position' => 'Sekretaris DPMPTSP'
        ]);

        DB::table('positions')->insert([
            'position' => 'Penilai Kelayakan Perizinan Madya'
        ]);

        DB::table('positions')->insert([
            'position' => 'Penilai Kelayakan Penanaman Modal Madya'
        ]);

        DB::table('positions')->insert([
            'position' => 'Analis Kebijakan Muda dan Evaluasi'
        ]);

        DB::table('positions')->insert([
            'position' => 'Analis Keuangan Pusat dan Daerah Muda'
        ]);

        DB::table('positions')->insert([
            'position' => 'Kasubag. Umum dan Kepegawaian'
        ]);

        DB::table('positions')->insert([
            'position' => 'Penilai Kelayakan Perizinan Muda'
        ]);

        DB::table('positions')->insert([
            'position' => 'Penilai Kelayakan Penanaman Modal Muda'
        ]);

        DB::table('positions')->insert([
            'position' => 'Kasi. Verifikasi Bidang Perijinan Tertentu & Non Perijinan'
        ]);

        DB::table('positions')->insert([
            'position' => 'Staff'
        ]);

        /**
         * Department
         */
        DB::table('departments')->insert([
            'department' => 'Sekretariat',
        ]);

        DB::table('departments')->insert([
            'department' => 'Bidang Penanaman Modal',
        ]);

        DB::table('departments')->insert([
            'department' => 'Bidang Perunian Tertentu dan Non Perunian',
        ]);

        DB::table('departments')->insert([
            'department' => 'Bidang Perunian Usaha',
        ]);

        DB::table('departments')->insert([
            'department' => 'Bidang Pengawasan dan Pengendalian',
        ]);

        /**
         * Sub Department
         */
        /**
         * Sekretariat
         */
        DB::table('sub_departments')->insert([
            'department_id' => 1,
            'sub_department' => 'Sub Bagian Umum dan Kepegawaian',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 1,
            'sub_department' => 'Sub Bagian Keuangan',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 1,
            'sub_department' => 'Sub Bagian Program dan Evaluasi',
        ]);

        /**
         * Bidang Penanaman Modal
         */
        DB::table('sub_departments')->insert([
            'department_id' => 2,
            'sub_department' => 'Seksi Pelayanan',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 2,
            'sub_department' => 'Seksi Perencanaan dan Pengembangan',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 2,
            'sub_department' => 'Seksi Promosi dan Kerjasama',
        ]);

        /**
         * Bidang Perunian Tertentu dan Non Perunian
         */
        DB::table('sub_departments')->insert([
            'department_id' => 3,
            'sub_department' => 'Seksi Pelayanan',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 3,
            'sub_department' => 'Seksi Verifikasi',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 3,
            'sub_department' => 'Seksi Penerbitan dan Pelaporan',
        ]);

        /**
         * Bidang Perunian Usaha
         */
        DB::table('sub_departments')->insert([
            'department_id' => 4,
            'sub_department' => 'Seksi Pelayanan',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 4,
            'sub_department' => 'Seksi Verifikasi',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 4,
            'sub_department' => 'Seksi Penerbitan dan Pelaporan',
        ]);

        /**
         * Bidang Pengawasan dan Pengendalian
         */
        DB::table('sub_departments')->insert([
            'department_id' => 5,
            'sub_department' => 'Seksi Penyelesaian Sengketa dan Pengaduan Masyarakat',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 5,
            'sub_department' => 'Seksi Pengawasan dan Pengendalian Perizinan',
        ]);

        DB::table('sub_departments')->insert([
            'department_id' => 5,
            'sub_department' => 'Seksi Data dan Informasi',
        ]);

        /**
         * Category
         */
        DB::table('categories')->insert([
            'category' => 'Keluhan',
        ]);

        DB::table('categories')->insert([
            'category' => 'Permintaan Barang',
        ]);

        /**
         * Ticket Status
         */
        DB::table('ticket_statuses')->insert([
            'status' => 'Dalam Antrian',
        ]);

        DB::table('ticket_statuses')->insert([
            'status' => 'Sedang Dikerjakan',
        ]);

        DB::table('ticket_statuses')->insert([
            'status' => 'Selesai',
        ]);

        DB::table('ticket_statuses')->insert([
            'status' => 'Ditolak',
        ]);

        /**
         * Technician Status
         */
        DB::table('technician_statuses')->insert([
            'status' => 'Available',
        ]);

        DB::table('technician_statuses')->insert([
            'status' => 'Busy',
        ]);

        User::factory(9)->create();
    }
}
