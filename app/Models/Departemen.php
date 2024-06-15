<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    public $table = 'departemen';
    protected $guarded = ['id'];

    public function report_terimapinjam() {
        return $this->hasMany(Report_terimapinjam::class);
    }
    public function user() {
        return $this->hasMany(User::class);
    }
    public function report_userit() {
        return $this->hasMany(Report_userit::class);
    }
    public function program() {
        return $this->hasMany(Programs::class);
    }
}
