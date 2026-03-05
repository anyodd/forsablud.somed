<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsopiut extends Model
{
    use HasFactory;
    protected $table = 'tb_sopiut';
    protected $fillable = ['Ko_Period','Ko_unit1','Ko_sKeg1','Ko_sKeg2','piut_doc','dt_piut','piut_ur','piut_nm','piut_addr','Ko_Rkk','piut_Rp','Tag','tb_ulog','created_at','updated_at'];
}