<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbpd extends Model
{
    use HasFactory;
    protected $table = 'tb_pd';
    protected $guarded = ['id'];
}
