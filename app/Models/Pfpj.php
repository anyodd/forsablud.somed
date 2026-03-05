<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pfpj extends Model
{
    use HasFactory;
    protected $table = 'pf_pj'; 
    protected $primaryKey = 'id_pj'; 
}
