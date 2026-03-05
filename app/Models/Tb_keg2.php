<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tb_keg2 extends Model
{
    use HasFactory;

    protected $table = 'tb_kegs2';
    protected $guarded = ['id', 'created_at'];
}
