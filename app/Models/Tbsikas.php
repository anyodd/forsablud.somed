<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsikas extends Model
{
    use HasFactory;
    protected $table = 'tb_sikas';
    protected $fillable = ['Ko_Period','Ko_unitstr', 'ko_sikas', 'sikas_no', 'dt_sikas', 'sikas_ur', 'no_oto','sikas_Rp','Tag','tb_ulog','created_at','updated_at'];
    protected $primaryKey = 'id_sikas';
}
