<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pfbank extends Model
{
    use HasFactory;
    protected $table = 'pf_bank'; 
    protected $primaryKey = 'Ko_Bank'; 
    protected $guarded = ['created_at'];
}
