<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbmutabank extends Model
{
    use HasFactory;
    protected $table = 'tb_mutabank';
    protected $fillable = ['Ko_Period', 'Ko_unitstr', 'Ko_Bank1', 'Ko_Bank2', 'muta_Rp', 'Tag', 'tb_ulog'];
    protected $guarded = [];
}
