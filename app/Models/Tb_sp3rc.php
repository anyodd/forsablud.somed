<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_sp3rc extends Model
{
    use HasFactory;
    protected $table = 'tb_sp3rc'; 
    protected $primaryKey = 'id_sp3rc';
    protected $dates = ['dt_rftrbprc'];
    protected $guarded = ['id_sp3rc', 'created_at'];
}
