<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pfwil1 extends Model
{
    use HasFactory;
    protected $table = 'pf_wil1'; 
    protected $primaryKey = 'Ko_Wil1';
	protected $fillable = [
        'Ur_wil1',
    ];	
	
    public function hasRelation()
    {
        return $this->wil2s()->exists()
            || $this->pemdas()->exists();
    }

	public function wil2s()
    {
        return $this->hasMany(Pfwil2::class, 'Ko_Wil1');
    }
	
    public function pemdas()
    {
        return $this->hasMany(Tbpemda::class, 'Ko_Wil1');
    }

	public function scopeGetSelect2($query)
    {
        return $query->pluck('Ur_wil1', 'Ko_Wil1')->prepend('Pilih Provinsi', '-1')->all();
    }
}
