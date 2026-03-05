<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soawlp extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_soawlp';
    protected $table = 'tb_soawlp';
    protected $fillable = ['Ko_Period', 'Ko_unitstr', 'Ko_lp', 'Ko_id', 'soaw_Rp', 'tb_ulog'];
}
