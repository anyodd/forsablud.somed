<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsts extends Model
{
    use HasFactory;
    protected $table = 'tb_sts';
    protected $primaryKey = 'id_sts';
    protected $fillable = ['Ko_Period', 'Ko_unitstr', 'No_sts', 'dt_sts', 'Ur_sts', 'Nm_Ben', 'NIP_Ben','Ko_Bank'];
    protected $guarded = [];

    public function tbstsrcs()
    {
        return $this->hasMany(Tbstsrc::class, 'id_sts', 'id_sts');
    }
}
