<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Departemen;
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
            'perusahaan_id'=>1,
            'departemen_id'=>1,
            'username'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('admin123'),
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

    }
}
