<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_userit extends Model
{
    use HasFactory;
    protected $table = 'report_userit';

    protected $guarded = ['id'];

    protected $with = ['perusahaan', 'departemen', 'users', 'jobs'];

    public function users() {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function departemen() {
        return $this->belongsTo(Departemen::class, 'user_req_departemen_id');
    }
    public function perusahaan() {
        return $this->belongsTo(Perusahaan::class, 'user_req_perusahaan_id');
    }
    public function jobs() {
        return $this->hasMany(Jobs::class, 'report_userit_id');
    }
}
