<?php

namespace App\Http\Controllers\definitif\spd;

use App\Http\Controllers\Controller;
use App\Models\Pfpdtap;
use App\Models\Tbpd;
use App\Models\Tbpdrc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SpdrinciController extends Controller
{
    public function index()
    {
        // 
    }

    public function pilih($id)
    {
        $spd = Tbpd::find($id);

        $query = "SELECT a.* FROM tb_pdrc a
                LEFT JOIN tb_pd b ON a.Ko_Period = b.Ko_Period AND a.Ko_unit1 = b.Ko_unit1 AND a.No_PD = b.No_PD
                WHERE b.Ko_Period = ? AND b.Ko_unit1 = ? AND b.No_PD = ?";

        $spd_rinc = DB::select($query, [
            Tahun(),
            kd_bidang(),
            $spd->No_PD
        ]);

        return view('definitif.spd.spdrinci.index', compact('spd_rinc', 'spd'));
    }

    public function create()
    {
        // 
    }

    public function tambah($id)
    {
        $spd = Tbpd::find($id);
        $pf_pdtap = Pfpdtap::all();

        $query_tap = "SELECT 
                    id, Ko_sKeg1, Ko_sKeg2, Ko_Rkk, Ko_Rk1, Ur_Rk6, To_Rp
                    FROM tb_tap
                    WHERE id_tap = (SELECT IFNULL(MAX(id_tap),1) AS id_tap FROM tb_tap where ko_unit1 = ?) 
                    AND Ko_Rk1 = 5 and ko_unit1 = ?";
        
        $tap = DB::select($query_tap, [
            getUser('ko_unit1'),
            getUser('ko_unit1')
        ]);

        $count_tap = count($tap);

        $ko_pdrc = DB::select(DB::raw("SELECT IFNULL(MAX(Ko_PDrc),1) AS Ko_PDrc FROM tb_pdrc WHERE Ko_Period = ? AND Ko_unit1 = ? AND No_PD = ?"), [$spd->Ko_Period, $spd->Ko_unit1, $spd->No_PD])[0];

        return view('definitif.spd.spdrinci.create', compact('tap', 'spd', 'pf_pdtap', 'ko_pdrc', 'count_tap'));
    }

    public function store(Request $request)
    {
        if ($request->waktu != 9) {
            $rules = [
                        "nomorSpd" => "required",
                        "tanggalSpd" => "required",
                        "uraianSpd" => "required",
                        "nomorRincian" => "required",
                        "waktu" => "required",
                    ];

            $messages = [
                        "nomorSpd.required" => "Nomor SPD wajib diisi.",
                        "tanggalSpd.required" => "Tanggal SPD wajib diisi.",
                        "uraianSpd.required" => "Uraian SPD wajib diisi.",
                        "nomorRincian.required" => "Nomor Rincian wajib diisi.",
                        "waktu.required" => "Silahkan Pilih Waktu SPD.",
                        ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            }

            if ($request->waktu == 1) {
                $pembagi = 12;
            } else if ($request->waktu == 2) {
                $pembagi = 4;
            } else if ($request->waktu == 3) {
                $pembagi = 3;
            } else if ($request->waktu == 4) {
                $pembagi = 2;
            } else if ($request->waktu == 5) {
                $pembagi = 1;
            }

            $sql1 = "SELECT (SELECT MAX(Ko_PDrc)
                    FROM tb_pdrc
                    WHERE Ko_Period = ? AND Ko_unit1 = ? AND No_PD = ?  AND a.Ko_Rk1 = 5) AS Ko_PDrc,
                    b.Ko_Period, b.Ko_unit1, b.No_PD, '' AS kode,
                    a.Ko_sKeg1, a.Ko_sKeg2, a.Ko_Rkk, a.Ur_Rk6, (a.To_Rp/?) AS To_Rp, a.tb_ulog, a.created_at, a.updated_at
                    FROM tb_tap a
                    LEFT JOIN tb_pd b ON a.Ko_Period = b.Ko_Period AND a.Ko_unit1 = b.ko_unit1
                    WHERE b.Ko_Period = ? AND b.Ko_unit1 = ? AND b.No_PD = ?  AND a.Ko_Rk1 = 5
                    AND a.id_tap = (SELECT MAX(id_tap) FROM tb_tap WHERE Ko_Period = ? AND Ko_unit1 = ? AND a.Ko_Rk1 = 5)";

            $array1 = DB::select($sql1, [Tahun(), getUser('ko_unit1'), $request->nomorSpd, $pembagi, Tahun(), getUser('ko_unit1'), $request->nomorSpd, Tahun(), getUser('ko_unit1')]);
            
            $jumlah = count($array1);
            $start_ko_pdrc = $array1[0]->Ko_PDrc;

            $array2 = array();

            foreach(range($start_ko_pdrc + 1, ($start_ko_pdrc + $jumlah)) as $i) {
                 $array2[] = $i;
            }

            $i = 0;

            foreach(range($start_ko_pdrc + 1, ($start_ko_pdrc + $jumlah)) as $row) {
                Tbpdrc::create([
                'Ko_Period' => Tahun(),
                'Ko_unit1' => getUser('ko_unit1'),
                'No_PD' => $array1[$i]->No_PD,
                'Tag_vpd' => $pembagi,
                'Tag_vpd1' => $request->periode,
                'Ko_PDrc' => $row,
                'Ko_sKeg1' => $array1[$i]->Ko_sKeg1,
                'Ko_sKeg2' => $array1[$i]->Ko_sKeg2,
                'Ko_Rkk' => $array1[$i]->Ko_Rkk,
                'Ur_Rc' => $array1[$i]->Ur_Rk6,
                'To_Rp' => $array1[$i]->To_Rp,
                'tb_ulog' => getUser('username'),
                'created_at' => now(),
                'updated_at' => now(),
                ]);

                $i++;
            }
        } else {
            $rules = [
                        "nomorSpd" => "required",
                        "tanggalSpd" => "required",
                        "uraianSpd" => "required",
                        "nomorKegiatanApbd" => "required",
                        "nomorKegiatanBlu" => "required",
                        "kodeAkun" => "required",
                        "nilaiRupiah" => "required",
                        "uraianAkun" => "required",
                        "nomorRincian" => "required",
                        "waktu" => "required",
                    ];

            $messages = [
                        "nomorSpd.required" => "Nomor SPD wajib diisi.",
                        "tanggalSpd.required" => "Tanggal SPD wajib diisi.",
                        "uraianSpd.required" => "Uraian SPD wajib diisi.",
                        "nomorKegiatanApbd.required" => "Nomor Kegiatan APBD wajib diisi.",
                        "nomorKegiatanBlu.required" => "Nomor Kegiatan BLU wajib diisi.",
                        "kodeAkun.required" => "Kode Akun wajib diisi.",
                        "nilaiRupiah.required" => "Nilai wajib diisi.",
                        "uraianAkun.required" => "Uraian Akun wajib diisi.",
                        "nomorRincian.required" => "Nomor Rincian wajib diisi.",
                        "waktu.required" => "Silahkan Pilih Waktu SPD.",
                    ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput($request->all);
                }

            $nomor_rincian = $request->nomorRincian + 1;

            Tbpdrc::create([
                'Ko_Period' => Tahun(),
                'Ko_unit1' => getUser('ko_unit1'),
                'No_PD' => $request->nomorSpd,
                'Tag_vpd' => 99,
                'Tag_vpd1' => 99,
                'Ko_PDrc' => $nomor_rincian,
                'Ko_sKeg1' => $request->nomorKegiatanApbd,
                'Ko_sKeg2' => $request->nomorKegiatanBlu,
                'Ko_Rkk' => $request->kodeAkun,
                'Ur_Rc' => $request->uraianAkun,
                'To_Rp' => $request->nilaiRupiah,
                'tb_ulog' => getUser('username'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        toast('Rincian SPD Nomor ' . $request->nomorSpd . ' berhasil dibuat', 'success');

        return redirect()->route('spd-rinci.pilih', $request->idSpd);
    }

    public function show($id)
    {
        // 
    }

    public function edit($id)
    {
        $spd_rinc = Tbpdrc::find($id);

        $query_spd = "SELECT a.* FROM tb_pd a
                    LEFT JOIN tb_pdrc b ON a.Ko_Period = b.Ko_Period AND a.Ko_unit1 = b.Ko_unit1 AND a.No_PD = b.No_PD
                    WHERE b.id = ? AND b.Ko_Period = ? AND b.Ko_unit1 = ? AND b.No_PD = ?";

        $spd = DB::select($query_spd, [
            $id,
            Tahun(),
            kd_bidang(),
            $spd_rinc->No_PD
        ])[0];

        $query_tap = "SELECT 
                    id, Ko_sKeg1, Ko_sKeg2, Ko_Rkk, Ur_Rk6, To_Rp
                    FROM tb_tap
                    WHERE id_tap = (SELECT IFNULL(MAX(id_tap),1) AS id_tap FROM tb_tap) AND Ko_Rk1 = 5";
        
        $tap = DB::select($query_tap);

        return view('definitif.spd.spdrinci.edit', compact('tap', 'spd', 'spd_rinc'));
    }

    public function update(Request $request, $id)
    {
        $spd_rinc = Tbpdrc::find($id);

        $rules = [
            "nomorSpd" => "required",
            "tanggalSpd" => "required",
            "uraianSpd" => "required",
            "nomorRincian" => "required",
            "nomorKegiatanApbd" => "required",
            "nomorKegiatanBlu" => "required",
            "kodeAkun" => "required",
            "nilaiRupiah" => "required",
            "uraianAkun" => "required",
        ];

        $messages = [
            "nomorSpd.required" => "Nomor SPD wajib diisi.",
            "tanggalSpd.required" => "Tanggal SPD wajib diisi.",
            "uraianSpd.required" => "Uraian SPD wajib diisi.",
            "nomorRincian.required" => "Nomor Rincian wajib diisi.",
            "nomorKegiatanApbd.required" => "Nomor Kegiatan APBD wajib diisi.",
            "nomorKegiatanBlu.required" => "Nomor Kegiatan BLU wajib diisi.",
            "kodeAkun.required" => "Kode Akun wajib diisi.",
            "nilaiRupiah.required" => "Nilai Rupiah wajib diisi.",
            "uraianAkun.required" => "Uraian Akun wajib diisi.",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $spd_rinc->Ko_Period = Tahun();
        $spd_rinc->Ko_unit1 = kd_bidang();
        $spd_rinc->No_PD = $request->nomorSpd;
        $spd_rinc->Ko_PDrc = $request->nomorRincian;
        $spd_rinc->Ko_sKeg1 = $request->nomorKegiatanApbd;
        $spd_rinc->Ko_sKeg2 = $request->nomorKegiatanBlu;
        $spd_rinc->Ko_Rkk = $request->kodeAkun;
        $spd_rinc->Ur_Rc = $request->uraianAkun;
        $spd_rinc->To_Rp = $request->nilaiRupiah;
        $spd_rinc->tb_ulog = getUser('username');
        $spd_rinc->updated_at = now();
        $spd_rinc->save();

        $query_spd = "SELECT a.* FROM tb_pd a
                    LEFT JOIN tb_pdrc b ON a.Ko_Period = b.Ko_Period AND a.Ko_unit1 = b.Ko_unit1 AND a.No_PD = b.No_PD
                    WHERE b.id = ? AND b.Ko_Period = ? AND b.Ko_unit1 = ? AND b.No_PD = ?";

        $spd = DB::select($query_spd, [
            $id,
            Tahun(),
            kd_bidang(),
            $spd_rinc->No_PD
        ])[0];

        toast('Rincian SPD Nomor ' . $request->nomorSpd . ' berhasil diubah', 'success');

        return redirect()->route('spd-rinci.pilih', $spd->id); 
    }

    public function destroy($id)
    {
        $spd_rinc = Tbpdrc::find($id);
        $spd_rinc->delete();
    }

    public function getTap(Request $request)
    {
        $query = "SELECT * FROM tb_tap WHERE id = ?";

        $tap = DB::select($query, [
            $request->id,
        ]);

        return response()->json($tap);
    }
}
