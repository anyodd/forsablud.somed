<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbkoreksi extends Model
{
    use HasFactory;
    protected $table = 'tb_koreksi';
    protected $primaryKey = 'id_korek';

    protected $fillable = ['Ko_Period', 'Ko_unitstr', 'Ko_Koreksi', 'Koreksi_No', 'Koreksi_Ur', 'No_spi', 'Ko_spirc', 'Ko_Rkk', 'Korek_Rp', 'Korek_Tag', 'Tag', 'tb_ulog'];
    protected $guarded = [];
}
