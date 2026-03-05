<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbrekan extends Model
{
    use HasFactory;
    protected $table = 'tb_rekan';
    protected $primarykey = 'id_rekan';
    protected $fillable = ['Ko_unitstr','rekan_nm','rekan_npwp','rekan_milikbank','rekan_rekbank','rekan_nmbank','rekan_adr','rekan_ph','rekan_mail', 'ko_usaha','Tag','tb_ulog','created_at','updated_at'];
}
