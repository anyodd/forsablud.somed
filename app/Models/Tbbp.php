<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbbp extends Model
{
    use HasFactory;
    protected $table = 'tb_bp';
    protected $fillable = ['id_bp','Ko_Period','Ko_unit1', 'Ko_bp', 'No_bp', 'dt_bp', 'dt_jt', 'Jn_Spm', 'Ur_bp', 'No_contr', 'nm_BUcontr','adr_bucontr','Nm_input','tb_ulog','created_at','updated_at'];
    protected $primaryKey = 'id_bp';
}
