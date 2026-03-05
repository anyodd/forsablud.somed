<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jrtran extends Model
{
    use HasFactory;
    protected $table = 'jr_trans';
    // protected $table = 'jr_trans_copy';
    protected $guarded = [];
}
