<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pfpmed extends Model
{
    use HasFactory;
    protected $table = 'pf_pmed'; 
    protected $primaryKey = 'ko_pmed'; 
    protected $guarded = ['id', 'created_at'];
}
