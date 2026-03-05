<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbcontrc extends Model
{
    use HasFactory;
    protected $table = 'tb_contrc';
    protected $fillable = ['id_contrc','id_contr', 'Ko_Period','Ko_unit1', 'No_contr', 'Ko_contrc', 'Ko_sKeg1', 'Ko_sKeg2', 'Ur_contr', 'Ko_Rkk', 'To_Rp','Tag','tb_ulog','created_at','updated_at'];
    protected $primaryKey = 'id_contrc';
}
