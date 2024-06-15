<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function report_userit() {
        return $this->hasMany(Report_userit::class);
    }
    public function program_perusahaan_id() {
        return $this->belongsTo(Perusahaan::class, 'program_perusahaan_id');
    }
    public function program_departemen_id() {
        return $this->belongsTo(Departemen::class, 'program_departemen_id');
    }
}
