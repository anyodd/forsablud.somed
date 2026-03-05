<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbtaxtorc extends Model
{
    use HasFactory;
    protected $table = 'tb_taxtorc';
    protected $fillable = ['id_taxtor','id_tax','taxtor_Rp','Tag','tb_ulog'];
    protected $primaryKey = 'id_taxtorc';
}
