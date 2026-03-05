<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbpjb extends Model
{
    use HasFactory;
    protected $table = 'tb_pjb'; 
    protected $primaryKey = 'id_pjb'; 
    protected $guarded = ['id', 'created_at'];

    public function jabatan(){
        return $this->belongsTo('App\Models\Pfpj', 'id_pj');
    }
}
