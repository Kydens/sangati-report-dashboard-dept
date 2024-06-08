<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_userit extends Model
{
    use HasFactory;
    protected $table = 'report_userit';

    protected $guarded = ['id'];

    protected $with = ['perusahaan', 'departemen', 'users'];

    public static function getStatuses(): array
    {
        return [
            'Proses'=>'Proses',
            'Done'=>'Done',
        ];
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d M Y');
    }
    public function users() {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function departemen() {
        return $this->belongsTo(Departemen::class, 'user_req_departemen_id');
    }
    public function perusahaan() {
        return $this->belongsTo(Perusahaan::class, 'user_req_perusahaan_id');
    }
}
