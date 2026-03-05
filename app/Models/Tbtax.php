<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbtax extends Model
{
    use HasFactory;
    protected $table = 'tb_tax';
    protected $primaryKey = 'id_tax';
    protected $fillable = ['id_bp', 'Ko_Period', 'Ko_unit1', 'No_bp', 'Ko_tax', 'Ko_Rkk', 'tax_Rp', 'Tag', 'tb_ulog'];
    protected $guarded = [];

    public function tbtaxors()
    {
        return $this->hasMany(Tbtaxor::class, 'id_tax', 'id_tax');
    }
}
