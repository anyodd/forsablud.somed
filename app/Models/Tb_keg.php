<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_keg extends Model
{
    use HasFactory;

    protected $table = 'tb_keg';
    protected $guarded = ['id', 'created_at'];
}
