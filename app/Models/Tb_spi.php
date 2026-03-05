<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_spi extends Model
{
    use HasFactory;
    protected $table = 'tb_spi';
    protected $fillable = ['id','Ko_Period','Ko_unitstr','Ko_SPi','No_SPi','Dt_SPi','Ur_SPi','Ko_Bank','Nm_PP','NIP_PP','Nm_Ben','NIP_Ben','Nm_Keu','NIP_Keu','trm_bank','trm_rek','Tag','tb_ulog']; 
    protected $dates = ['Dt_SPi'];
}
