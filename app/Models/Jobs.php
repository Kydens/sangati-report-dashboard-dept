<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function getStatuses(): array
    {
        return [
            'Proses'=>'Proses',
            'Done'=>'Done',
        ];
    }

    public function report_userit() {
        return $this->belongsTo(Report_userit::class, 'report_userit_id');
    }
}
