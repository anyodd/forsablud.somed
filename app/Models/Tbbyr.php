<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbbyr extends Model
{
    use HasFactory;
    protected $table = 'tb_byr';
    protected $primaryKey = 'id_byr';
    protected $fillable = ['id_bprc','Ko_Period','Ko_unitstr','No_byr','dt_byr','Ur_byr','No_bp','Ko_bprc','real_rp','ko_kas','Ko_Bank','Nm_Byr','Tag','tb_ulog','created_at','updated_at'];
}
