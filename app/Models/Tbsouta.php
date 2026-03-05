<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsouta extends Model
{
    use HasFactory;
    protected $table = 'tb_souta';
    protected $fillable = ['Ko_Period','Ko_unit1','uta_doc','dt_uta','jt_uta','uta_ur','id_rekan','uta_nm','uta_addr','Ko_sKeg1','Ko_sKeg2','Ko_Rkk','uta_Rp','Tag','tb_ulog','created_at','updated_at'];
}
