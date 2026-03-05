<?php

namespace App\Http\Controllers\Laporan\Perencanaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Session;
use Illuminate\Support\Facades\DB;
use PDF;

class RkaController extends Controller
{
    public function rka1_pendapatan() #rka pendapatan
    {
        $calon_data = DB::select("call qr_RKA1pdp(".Tahun().", '".kd_unit()."')");
        $data = collect($calon_data);

        $jumlah = DB::table('vqr_RKA1pdp')
        ->where([ 'Ko_Period'=>Tahun() ])
        ->whereRaw("left(Ko_unit1, 18) = '".kd_unit()."'")
        ->sum('To_Rp');

        return view('laporan.perencanaan.rka.rka1_pendapatan', compact('data', 'jumlah'));
    }

    public function rka1_pendapatan_pdf() #rka pendapatan
    {
        $calon_data = DB::select("call qr_RKA1pdp(".Tahun().", '".kd_unit()."')");
        $data = collect($calon_data);

        $jumlah = DB::table('vqr_RKA1pdp')
        ->where([ 'Ko_Period'=>Tahun() ])
        ->whereRaw("left(Ko_unit1, 18) = '".kd_unit()."'")
        ->sum('To_Rp');

        $pdf = PDF::loadView('laporan.perencanaan.rka.rka1_pendapatan_pdf', compact('data', 'jumlah'))->setPaper('A4', 'portrait');

        // return $pdf->download('RKA Pendapatan Tahun '.$Ko_Period.'.pdf');
        // return $pdf->stream('RKA Pendapatan Tahun '.$Ko_Period.'.pdf');
        // return $pdf->stream();
        return $pdf->stream('RKA Pendapatan Tahun '.Tahun().'.pdf',  array("Attachment" => false));   // gak pengaruh??
        // return $pdf->stream('RKA Pendapatan Tahun '.$Ko_Period.'.pdf',  array("Attachment" => 0));          // gak pengaruh??
    }

    public function rka2_belanja() #rka belanja
    {
        $calon_data = DB::select("call qr_RKA2(".Tahun().", '".kd_unit()."')");
        $data = collect($calon_data);
        $jumlah = $data->sum('To_Rp');

        return view('laporan.perencanaan.rka.rka2_belanja', compact('data', 'jumlah'));
    }

    public function rka2_belanja_pdf() #rka belanja
    {
        $calon_data = DB::select("call qr_RKA2(".Tahun().", '".kd_unit()."')");
        $data = collect($calon_data);
        $jumlah = $data->sum('To_Rp');

        $pdf = PDF::loadView('laporan.perencanaan.rka.rka2_belanja_pdf', compact('data', 'jumlah'))->setPaper('A4', 'portrait');

        return $pdf->stream('RKA Belanja Tahun '.Tahun().'.pdf',  array("Attachment" => false));
    }

    public function rka3_terima_biaya() #rka penerimaan pembiayaan
    {
        $calon_data = DB::select("call qr_RKA31(".Tahun().", '".kd_unit()."')");
        $data = collect($calon_data);

        $jumlah = $data->sum('To_Rp');

        return view('laporan.perencanaan.rka.rka3_terima_biaya', compact('data', 'jumlah'));
    }

    public function rka3_terima_biaya_pdf() #rka penerimaan pembiayaan pdf
    {
        $calon_data = DB::select("call qr_RKA31(".Tahun().", '".kd_unit()."')");
        $data = collect($calon_data);

        $jumlah = $data->sum('To_Rp');

        $pdf = PDF::loadView('laporan.perencanaan.rka.rka3_terima_biaya_pdf', compact('data', 'jumlah'))->setPaper('A4', 'portrait');

        return $pdf->stream('RKA Penerimaan Pembiayaan Tahun '.Tahun().'.pdf', array("Attachment" => false));
    }

    public function rka4_keluar_biaya() #rka pengeluaran pembiayaan
    {
        $calon_data = DB::select("call qr_RKA32(".Tahun().", '".kd_unit()."')");
        $data = collect($calon_data);

        $jumlah = $data->sum('To_Rp');

        return view('laporan.perencanaan.rka.rka4_keluar_biaya', compact('data', 'jumlah'));
    }

    public function rka4_keluar_biaya_pdf() #rka pengeluaran pembiayaan
    {
        $calon_data = DB::select("call qr_RKA32(".Tahun().", '".kd_unit()."')");
        $data = collect($calon_data);

        $jumlah = $data->sum('To_Rp');

        $pdf = PDF::loadView('laporan.perencanaan.rka.rka4_keluar_biaya_pdf', compact('data', 'jumlah'))->setPaper('A4', 'portrait');

        return $pdf->stream('RKA Pengeluaran Pembiayaan Tahun '.Tahun().'.pdf',  array("Attachment" => false));
    }
}
