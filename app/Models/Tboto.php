<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tboto extends Model
{
    use HasFactory;
    protected $table = 'tb_oto';
    protected $guarded = ['id', 'created_at'];
}
