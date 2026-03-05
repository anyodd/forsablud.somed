<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pfskeg extends Model
{
    use HasFactory;
    protected $table = 'pf_skeg'; 
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
