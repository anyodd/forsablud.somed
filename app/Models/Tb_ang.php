<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_ang extends Model
{
    use HasFactory;

    protected $table="tb_ang";

    protected $fillable = ['Ko_Period','ko_unit1', 'Ko_sKeg1', 'Ko_sKeg2', 'Ko_Rk1', 'Ko_Rk2', 'Ko_Rk3', 'Ko_Rk4', 'Ko_Rk5', 'Ko_Rk6', 'Ko_Rkk', 'Ur_Rc'];
}
