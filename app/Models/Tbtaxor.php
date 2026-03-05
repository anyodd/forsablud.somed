<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbtaxor extends Model
{
    use HasFactory;
    protected $table = 'tb_taxtor';
    protected $primaryKey = 'id_taxtor';
    protected $fillable = ['id_rekan', 'Ko_Period', 'id_rekan', 'Ko_unit1', 'Ur_taxtor', 'Ko_Rkk', 'Ko_Bank', 'No_ntpn','dt_taxtor', 'No_bill', 'Tag', 'tb_ulog'];
    protected $guarded = [];

    public function tbtax()
    {
        return $this->belongsTo(Tbtax::class, 'id_tax', 'id_tax');
    }
}
