<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsesuai extends Model
{
    use HasFactory;
    protected $table = 'tb_sesuai';
    protected $primaryKey = 'id_tbses';
    protected $fillable = ['Ko_Period', 'Ko_unitstr', 'Ko_jr', 'dt_sesuai','Sesuai_No', 'Sesuai_Ur', 'tag', 'tb_ulog'];
    protected $guarded = [];

    public function Jrsesuais()
    {
        return $this->hasMany(Jrsesuai::class, 'id_tbses', 'id_tbses');
    }
}
