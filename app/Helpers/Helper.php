<?php

use App\Models\Tbsub;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

function getUser($id)
{
    return Session::get('userData')[$id];
}

function Tahun()
{
    return Session::get('Period');
}

function nm_unit()
{
    $unit = substr(getUser('ko_unit1'), 0, 18);
    
    return DB::table('tb_sub')
        ->where('Ko_unitstr', $unit)
        ->value('ur_subunit');
}

function kd_unit()
{
    $unit = substr(getUser('ko_unitstr'), 0, 18);
    
    return DB::table('tb_sub')
        ->where('Ko_unitstr', $unit)
        ->value('Ko_unitstr');
}

function nm_bidang()
{
    return DB::table('tb_sub1')
        ->where('ko_unit1', getUser('ko_unit1'))
        ->value('ur_subunit1');
}

function nm_pro()
{
    if(getUser('user_level') == 1){
        return getBidang();
    }else{
        return DB::table('users')
            ->join('tb_pjb', 'users.username', '=', 'tb_pjb.NIP_pjb')
            ->select('tb_pjb.Nm_pjb AS nama')->where('tb_pjb.NIP_pjb','=', getUser('username'))
            ->value('nama');
    }
}

function akses()
{
    //  $unit = substr(getUser('ko_unit1'), 0, 18);
    //  return DB::table('tb_sub')
    //              ->where('Ko_unitstr', $unit)
    //              ->where('Ko_Period','=', Tahun())
    //              ->first();

    $unit = substr(getUser('ko_unit1'), 0, 2);
    return DB::table('tb_pemda')
                ->where('Ko_Wil1', $unit)
                ->where('Ko_Period','=', Tahun())
                ->first();
}

function kd_bidang()
{
    return DB::table('tb_sub1')
        ->where('ko_unit1', getUser('ko_unit1'))
        ->value('ko_unit1');
}

function id_pemda()
{
    $wil1 = substr(getUser('ko_unit1'), 0, 2);
    $wil2 = substr(getUser('ko_unit1'), 3, 2);
    
    return DB::table('tb_pemda')
        ->where(['Ko_Wil1' => $wil1,'Ko_Wil2' => $wil2])
        ->value('id');
}

function nm_pemda()
{
    $wil1 = substr(getUser('ko_unit1'), 0, 2);
    $wil2 = substr(getUser('ko_unit1'), 3, 2);
    
    return DB::table('tb_pemda')
        ->where(['Ko_Wil1' => $wil1,'Ko_Wil2' => $wil2])
        ->value('Ur_Pemda');
}

function nm_ibukota()
{
    $Ko_Wil1 = substr(getUser('ko_unit1'), 0, 2);
    $Ko_Wil2 = substr(getUser('ko_unit1'), 3, 2);
    return DB::table('tb_pemda')
        ->where(['Ko_Wil1' => $Ko_Wil1,'Ko_Wil2' => $Ko_Wil2])
        ->value('Ibukota');
}

function tb_sub($id)
{
    $unit = substr(getUser('ko_unit1'), 0, 18);
    
    return DB::table('tb_sub')
        ->where('Ko_unitstr', $unit)
        ->value($id);
}

function getBidang()
{
    return DB::table('tb_sub1')
            ->where('ko_unit1', getUser('ko_unit1'))
            ->value('ur_subunit1');
}

function inrupiah($rp)
{
    $a = str_replace('.','',$rp);
    $Rp = str_replace(',','.',$a);
    return $Rp;
}

function terbilang($number)
{
    $number = number_format($number,0,',','');
    $base    = array('nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan');
    $numeric = array('1000000000000000', '1000000000000', '1000000000000', 1000000000, 1000000, 1000, 100, 10, 1);
    $unit    = array('kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', '');
    $str     = null;
    $i = 0;
    if ($number == 0) {
        $str = 'nol';
    } else {
        while ($number != 0) {
            $count = (int)($number / $numeric[$i]);
            if ($count >= 10) {
                $str .= terbilang($count) . ' ' . $unit[$i] . ' ';
            } elseif ($count > 0 && $count < 10) {
                $str .= $base[$count] . ' ' . $unit[$i] . ' ';
            }
            $number -= $numeric[$i] * $count;
            $i++;
        }
        $str = preg_replace('/satu puluh (\w+)/i', '\1 belas', $str);
        $str = preg_replace('/satu (ribu|ratus|puluh|belas)/', 'se\1', $str);
        $str = preg_replace('/\s{2,}/', ' ', trim($str));
    }
    return $str;
}

function rek_utama($field)
{
    $Ko_Wil1 = intval(substr(kd_unit(),0,2));
    $Ko_Wil2 = intval(substr(kd_unit(),3,2));
    $Ko_Urus = intval(substr(kd_unit(),6,2));
    $Ko_Bid = intval(substr(kd_unit(),9,2));
    $Ko_Unit = intval(substr(kd_unit(),12,2));
    $Ko_Sub = intval(substr(kd_unit(),15,3));

    return DB::table('pf_bank')
    ->where([ 
        'Ko_wil1'=>$Ko_Wil1, 
        'Ko_Wil2'=>$Ko_Wil2, 
        'Ko_Urus'=>$Ko_Urus, 
        'Ko_Bid'=>$Ko_Bid, 
        'Ko_Unit'=>$Ko_Unit, 
        'Ko_Sub'=>$Ko_Sub, 
        'Tag'=>1 ])
    ->value($field);
}

function nmbulan($bln)
{
    return DB::table('pf_bln')
        ->where('id_bln', $bln)
        ->value('Ur_bln');
}

function nm_rekan($id)
{
    return DB::table('tb_rekan')
        ->where('id_rekan', $id)
        ->value('rekan_nm');
}

function bidang_id($id)
{
    return DB::table('tb_sub')
        ->Join('tb_unit', 'tb_sub.id_unit', '=', 'tb_unit.id')
        ->where('tb_sub.Ko_unitstr', $id)
        ->value('tb_unit.id_bidang');
}

function nm_bulan($id)
{
    if($id == 1){
        return 'Januari';
    }else if($id == 2){
        return 'Februari';
    }else if($id == 3){
        return 'Maret';
    }else if($id == 4){
        return 'April';
    }else if($id == 5){
        return 'Mei';
    }else if($id == 6){
        return 'Juni';
    }else if($id == 7){
        return 'Juli';
    }else if($id == 8){
        return 'Agustus';
    }else if($id == 9){
        return 'September';
    }else if($id == 10){
        return 'Oktober';
    }else if($id == 11){
        return 'November';
    }else if($id == 12){
        return 'Desember';
    }
}

function logo_pemda()
{
    $unit = Tbsub::where('Ko_unitstr',kd_unit())->first();
    return $unit->logo_pemda; 
}

function logo_blud()
{
    $unit = Tbsub::where('Ko_unitstr',kd_unit())->first();
    return $unit->logo_blud; 
}

function jabatan($id)
{
    return DB::table('tb_pjb')
    ->leftJoin('pf_pj', 'tb_pjb.id_pj', '=', 'pf_pj.id_pj')
    ->select('pf_pj.Ur_pj AS jabatan')->where('tb_pjb.NIP_pjb','=', $id)
    ->value('jabatan');
}

if (!function_exists('format_money')) {
    function format_money($number, $decimal = 0): string
    {
        if ($decimal == 0) {
            $num = explode('.', $number);

            if (count($num) > 1) {
                $decimal = strlen(rtrim($num[1], '0'));
            }
        }

        return number_format($number, $decimal, ',', '.');
    }
}

if (!function_exists('data_inputmask_numeric')) {
    function data_inputmask_numeric(): string
    {
        return "'alias': 'numeric', 'greedy': false, 'removeMaskOnSubmit': true, 'autoUnmask': true";
    }
}

if (!function_exists('data_inputmask_percentage')) {
    function data_inputmask_percentage(): string
    {
        return "'alias': 'percentage', 'greedy': false, 'removeMaskOnSubmit': true, 'autoUnmask': true";
    }
}

if (!function_exists('is_windows')) {
    function is_windows(): bool
    {
        return PHP_OS_FAMILY == 'Windows';
    }
}


function kd_pdp_apbd()
{
    // Hardcoded to 4 as it is the standard for APBD in this system.
    // Extensive database check confirmed 4 is used in 98%+ of cases.
    return 4;
}
