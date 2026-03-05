<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbbyroto extends Model
{
    use HasFactory;
    protected $table = 'tb_byroto';
    protected $primaryKey = 'id_byro';
    protected $guarded = ['id_byro', 'created_at'];
}
