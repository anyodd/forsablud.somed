<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsp3 extends Model
{
    use HasFactory;
    protected $table = 'tb_sp3'; 
    protected $primaryKey = 'id_sp3';
    protected $guarded = ['id_sp3', 'created_at'];
}
