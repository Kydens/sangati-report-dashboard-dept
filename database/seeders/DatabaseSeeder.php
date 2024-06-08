<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Departemen;
use App\Models\Roles;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Report_terimapinjam;
use App\Models\Tanda_terimapinjam;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'roles_id'=>1,
            'perusahaan_id'=>1,
            'departemen_id'=>1,
            'username'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('admin123'),
        ]);

        User::create([
            'roles_id'=>1,
            'perusahaan_id'=>1,
            'departemen_id'=>2,
            'username'=>'nisa',
            'email'=>'nisa@gmail.com',
            'password'=>bcrypt('12345'),
        ]);

        User::create([
            'roles_id'=>1,
            'perusahaan_id'=>1,
            'departemen_id'=>4,
            'username'=>'venny',
            'email'=>'venny@gmail.com',
            'password'=>bcrypt('12345'),
        ]);

        User::create([
            'roles_id'=>2,
            'perusahaan_id'=>1,
            'departemen_id'=>4,
            'username'=>'zidan',
            'email'=>'zidan@gmail.com',
            'password'=>bcrypt('12345'),
        ]);

        Tanda_terimapinjam::create([
            'jenis'=>'Tanda Terima'
        ]);

        Tanda_terimapinjam::create([
            'jenis'=>'Tanda Pinjam'
        ]);

        Perusahaan::create([
            'nama_perusahaan'=>'PT. Sangati Soerya Sejahtera',
            'image'=>'post-images/sangati.png'
        ]);

        Perusahaan::create([
            'nama_perusahaan'=>'PT. L&M Systems Indonesia',
            'image'=>'post-images/lmsi.jpg'
        ]);

        Perusahaan::create([
            'nama_perusahaan'=>'PT. Beberes Rumah Sejahtera',
            'image'=>'post-images/nyaman.jpg'
        ]);

        Departemen::create([
            'nama_departemen'=>'ADMIN',
        ]);

        Departemen::create([
            'nama_departemen'=>'HRD',
        ]);

        Departemen::create([
            'nama_departemen'=>'Purchasing',
        ]);

        Departemen::create([
            'nama_departemen'=>'IT',
        ]);

        Departemen::create([
            'nama_departemen'=>'Accounting',
        ]);

        Departemen::create([
            'nama_departemen'=>'Finance',
        ]);

        Departemen::create([
            'nama_departemen'=>'Payroll',
        ]);

        Departemen::create([
            'nama_departemen'=>'Operation',
        ]);

        Roles::create([
            'nama_role'=>'Admin',
        ]);

        Roles::create([
            'nama_role'=>'User',
        ]);

    }
}
