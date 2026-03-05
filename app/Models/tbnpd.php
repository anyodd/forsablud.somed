<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbnpd extends Model
{
    use HasFactory;

    protected $table = 'tb_npd';
    protected $primaryKey = 'id_npd';
    protected $guarded = ['id_npd', 'created_at'];
}
