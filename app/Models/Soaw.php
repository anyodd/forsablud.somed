<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soaw extends Model
{
    use HasFactory;
    protected $table = 'tb_soaw';
    protected $fillable = ['Ko_Period', 'Ko_unitstr', 'ko_rkk5', 'soaw_Rp', 'soaw_Rp_D', 'soaw_Rp_K', 'Tag', 'tb_ulog'];
    protected $guarded = [];
}
