<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsp2 extends Model
{
    use HasFactory;
    // protected $table = 'tb_sp2';
    protected $table = 'tb_sp2';
    protected $primaryKey = 'id_sp2';
    // protected $dates = ['Dt_sp2'];
    protected $guarded = ['id_sp2', 'created_at'];
}
