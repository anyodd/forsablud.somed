<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pfurus extends Model
{
    const JNS_PEMDA_PROVINSI = 1;
    const JNS_PEMDA_KABUPATEN_KOTA = 2;

    use HasFactory;
    protected $table = 'pf_urus'; 
    protected $primaryKey = 'id_urus'; 

    public function hasRelation()
    {
        return $this->bidangs()->exists();
    }

    public function bidangs()
    {
        return $this->hasMany(Pfbid::class, 'id_urus');
    }

    public function scopeJnspemda($query, $jns_pemda = 0)
    {
        return $query->where('jns_pemda', $jns_pemda);
    }

    public function scopeGetSelect2($query, $jns_pemda = 0)
    {
        if ($jns_pemda) {
            $query = $query->jns_pemda($jns_pemda);
        }

        return $query->addSelect(['id_urus', DB::raw("CONCAT(Ko_Urus, '. ', Ur_Urus) AS Ur_Urus")])->pluck('Ur_Urus', 'id_urus')->prepend('Pilih Urusan Pemerintahan', '')->all();
    }

    public static function getJnsPemdaIni()
    {
        $pemda = id_pemda();
        $Tbpemda = Pfurus::firstOrFail()->where('id', $pemda->id ?? 0);
        return $Tbpemda->Ko_Wil2 == 0 ? Pfurus::JNS_PEMDA_PROVINSI : Pfurus::JNS_PEMDA_KABUPATEN_KOTA;
    }
}
