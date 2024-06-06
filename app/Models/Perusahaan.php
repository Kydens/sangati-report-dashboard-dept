<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    public $table = "perusahaan";

    protected $guarded = ['id'];

    public function report_terimapinjam() {
        return $this->hasMany(Report_terimapinjam::class);
    }
    public function user() {
        return $this->hasMany(User::class);
    }
}