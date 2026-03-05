<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbsub extends Model
{
    use HasFactory;
    protected $table = 'tb_sub'; 
    protected $primaryKey = 'id';
    protected $guarded = ['id', 'created_at'];

    public function hasRelation()
    {
        // return $this->Sys_users()->exists()
        // || $this->Tbsub1s()->exists();
        // || return $this->Tbsub1s()->exists();
    }

    public function getEntityCodeAttribute()
    {
        return $this->Tbunit->entity_code . '.' . substr('000' . $this->Ko_sub, -3);
    }

    public function getEntityNameWithCodeAttribute()
    {
        return $this->entity_code . ' ' . $this->ur_subunit;
    }

    public function units()
    {
        return $this->belongsTo(Tbunit::class, 'id');
    }

    public function sub1s()
    {
        return $this->hasMany(Tbsub1::class, 'id_sub');
    }

    // public function users()
    // {
    //     return $this->belongsToMany(Sys_user::class, 'users', 'ko_unitstr', 'user_id');
    // }
	
	private function checkFolder($directoryName)
    {
        if (!is_dir($directoryName)) {
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755, true);
        }
    }
	
	private function checkFile($filePath)
    {
        return file_exists($filePath);
    }
	
	public function getLogoImagePemda()
    {   
        
        $unit = Tbsub::where('Ko_unitstr',kd_unit())->first();
        if (!$unit->logo_pemda ) return public_path('template/dist/img/transparent.png');

        $baseUrl ='logo/pemda/';
        $file = $unit->logo_pemda;
        $fullFilePath = public_path($baseUrl) . $file;

        $this->checkFolder(public_path($baseUrl));

        if (!$this->checkFile($fullFilePath)) return public_path('template/dist/img/transparent.png');
        return $fullFilePath;
    }
	
	public function getLogoImageRs()
    {
        $unit = Tbsub::where('Ko_unitstr',kd_unit())->first();
        if (!$unit->logo_blud ) return public_path('template/dist/img/transparent.png');

        $baseUrl ='logo/blud/';
        $file = $unit->logo_blud;
        $fullFilePath = public_path($baseUrl) . $file;

        $this->checkFolder(public_path($baseUrl));

        if (!$this->checkFile($fullFilePath)) return public_path('template/dist/img/transparent.png');
        return $fullFilePath;
    }

    public function scopeSubUnitAktif($query)
    {
        return $query->first();
    }

    public function scopeGetSelect2($query, $id_unit = 0)
    {
        return $query->where('id_unit', $id_unit)->pluck('ur_subunit', 'id')->prepend('Pilih BLUD', '')->all();
    }
}
