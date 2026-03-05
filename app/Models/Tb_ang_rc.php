<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_ang_rc extends Model
{
    use HasFactory;

    protected $table="tb_ang_rc";

    protected $fillable = ['Ko_Period','ko_unit1', 'Ko_sKeg1', 'Ko_sKeg2', 'Ko_Rkk', 'Ko_Pdp', 'Ko_Rc', 'Ur_Rc1', 'V_1', 'Rp_1', 'V_sat', 'To_Rp'];

}
