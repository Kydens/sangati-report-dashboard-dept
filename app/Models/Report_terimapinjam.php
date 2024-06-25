<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_terimapinjam extends Model
{
    use HasFactory;

    public $table = "report_terimapinjam";
    protected $guarded = ['id'];
    protected $with = ['perusahaan', 'tanda_terimapinjam'];
    protected $casts = [
        'created_at'=>'datetime',
        'terakhir_cetak'=>'datetime',
    ];


    public function perusahaan() {
        return $this->belongsTo(Perusahaan::class);
    }
    public function tanda_terimapinjam() {
        return $this->belongsTo(Tanda_terimapinjam::class);
    }
    public function departemen() {
        return $this->belongsTo(Departemen::class);
    }
    public function item() {
        return $this->hasMany(Item::class);
    }
    public function pengirim_dept()
    {
        return $this->belongsTo(Departemen::class, 'pengirim_dept_id');
    }
    public function penerima_dept()
    {
        return $this->belongsTo(Departemen::class, 'penerima_dept_id');
    }
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d M Y');
    }
}
