<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbstsrc extends Model
{
    use HasFactory;
    protected $table = 'tb_stsrc';
    protected $primaryKey = 'id_sts';
    protected $fillable = ['id_sts', 'Ko_Period', 'Ko_unitstr', 'No_sts', 'Ko_stsrc', 'No_byr', 'tb_ulog'];
    protected $guarded = [];

    public function tbsts()
    {
        return $this->belongsTo(Tbsts::class, 'id_sts', 'id_sts');
    }
}
