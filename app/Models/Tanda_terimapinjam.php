<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanda_terimapinjam extends Model
{
    use HasFactory;

    public $table = "tanda_terimapinjam";

    protected $guarded = ['id'];

    public function report_terimapinjam() {
        return $this->hasMany(Report_terimapinjam::class);
    }
}
