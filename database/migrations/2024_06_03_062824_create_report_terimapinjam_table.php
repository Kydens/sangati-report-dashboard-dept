<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_terimapinjam', function (Blueprint $table) {
            $table->id();
            $table->integer('kop_id')->unique()->nullable();
            $table->foreignId('perusahaan_id');
            $table->foreignId('departemen_id');
            $table->foreignId('tanda_terimapinjam_id');
            $table->string('pengirim');
            $table->foreignId('pengirim_dept_id');
            $table->string('penerima');
            $table->foreignId('penerima_dept_id');
            $table->timestamp('terakhir_cetak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_terimapinjam');
    }
};
