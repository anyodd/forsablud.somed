<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tblogv extends Model
{
    use HasFactory;
    protected $table = 'tb_logv';
    protected $fillable = ['id_log', 'id_spi', 'Tag_v', 'ur_logv', 'Tag', 'tb_ulog','created_at','updated_at'];
}
