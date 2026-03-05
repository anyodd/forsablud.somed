<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pfbid extends Model
{
    use HasFactory;
    protected $table = 'pf_bid'; 
    protected $primaryKey = 'id_bidang'; 

    public function urusan()
    {
        return $this->belongsTo(Pfurus::class, 'id_urus');
    }

    public function units()
    {
        return $this->hasMany(Tbunit::class, 'id_bidang');
    }

    public function scopeGetSelect2($query)
    {
        return $query->addSelect(['id_bidang', DB::raw("CONCAT(Ko_Urus, '.', Ko_Bid, '. ', Ur_Bid) AS Ur_Bid")])->pluck('Ur_Bid', 'id_bidang')->prepend('Pilih Bidang', '')->all();
    }
}
