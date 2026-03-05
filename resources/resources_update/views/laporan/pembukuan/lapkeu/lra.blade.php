<div class="header d-flex text-center align-content-center col-lg-12 justify-content-around align-items-center">
    <div class="header-center">
        <h4>{{ nm_unit() }}</h4>
        <h6>LAPORAN REALISASI ANGGARAN</h6>
        <h6>UNTUK TAHUN YANG BERAKHIR SAMPAI DENGAN 31 DESEMBER {{ Tahun() }} DAN {{ Tahun()-1 }}</h6>
    </div>
</div>

<div class="content mt-5">
    <table class="table table-sm table-bordered">
        <thead>
            <tr class="">
                <th scope="col" class="align-middle text-center">No</th>
                <th scope="col" class="align-middle text-center">Uraian</th>
                <th scope="col" class="align-middle text-center">Anggaran 2021</th>
                <th scope="col" class="align-middle text-center">Realisasi 2021</th>
                <th scope="col" class="align-middle text-center">(%)</th>
                <th scope="col" class="align-middle text-center">Realisasi 2020</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center align-middle no-border"></td>
                <td class="text-start text-uppercase text-decoration-underline font-weight-bold no-border">PENDAPATAN
                </td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
            </tr>

            @foreach ($lra_p as $number => $lra_p)
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">{{ $lra_p->Ur_Rc1}}</td>
                <td class="text-right no-border">{{ number_format($lra_p->Rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_p->Realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_p->Rencana == 0 ? 0 : number_format($lra_p->Realisasi/$lra_p->Rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
            @endforeach

            <tr class="font-weight-bold" style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end no-border">Jumlah Pendapatan</td>
                <td class="text-right no-border">{{ $lra_p_jum == NULL ? 0 : number_format($lra_p_jum->Rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_p_jum == NULL ? 0 : number_format($lra_p_jum->Realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_p_jum->Rencana == 0 ? 0 : number_format($lra_p_jum->Realisasi/$lra_p_jum->Rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
            </tr>

            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-start text-uppercase text-decoration-underline font-weight-bold no-border">BELANJA</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-uppercase font-weight-bold no-border ps-4">BELANJA OPERASI</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
            </tr>

            @foreach ($lra_bo as $number => $lra_bo)
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">{{ $lra_bo->Ur_Rc1}}</td>
                <td class="text-right no-border">{{ number_format($lra_bo->Rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_bo->Realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_bo->Rencana == 0 ? 0 : number_format($lra_bo->Realisasi/$lra_bo->Rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
            @endforeach

            <tr class="font-weight-bold" style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end no-border">Jumlah Belanja Operasi</td>
                <td class="text-right no-border">{{ number_format($lra_bo_rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_bo_realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_bo_rencana == 0 ? 0 : number_format($lra_bo_realisasi/$lra_bo_rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
            </tr>

            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-uppercase font-weight-bold no-border ps-4">BELANJA MODAL</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
            </tr>

            @foreach ($lra_bm as $number => $lra_bm)
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">{{ $lra_bm->Ur_Rc1}}</td>
                <td class="text-right no-border">{{ number_format($lra_bm->Rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_bm->Realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_bm->Rencana == 0 ? 0 : number_format($lra_bm->Realisasi/$lra_bm->Rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
            @endforeach

            {{-- 
            <tr class="font-weight-bold" style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">Jumlah Belanja Modal</td>
                <td class="text-right no-border">{{ number_format($lra_bm_jum->Rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_bm_jum->Realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_bm_jum->Rencana == 0 ? 0 : number_format($lra_bm_jum->Realisasi/$lra_bm_jum->Rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
            --}}

            <tr class="font-weight-bold" style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">Jumlah Belanja Modal</td>
                <td class="text-right no-border">{{ number_format($lra_bm_rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_bm_realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_bm_rencana == 0 ? 0 : number_format($lra_bm_realisasi/$lra_bm_rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
            <tr class="font-weight-bold" style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">Jumlah Belanja</td>
                <td class="text-right no-border">{{ number_format($lra_b_jum->Rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_b_jum->Realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_b_jum->Rencana == 0 ? 0 : number_format($lra_b_jum->Realisasi/$lra_b_jum->Rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">&nbsp;</td>
                <td class="font-weight-bold text-center">&nbsp;</td>
                <td class="font-weight-bold text-center">&nbsp;</td>
                <td class="font-weight-bold text-center">&nbsp;</td>
                <td class="font-weight-bold text-center">&nbsp;</td>
            </tr>
            <tr class="font-weight-bold" style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold">SURPLUS / DEFISIT</td>
                <td class="text-right no-border">{{ number_format($lra_surplus->Rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_surplus->Realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_surplus->Rencana == 0 ? 0 : number_format($lra_surplus->Realisasi/$lra_surplus->Rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>

            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-start text-uppercase text-decoration-underline font-weight-bold no-border">PEMBIAYAAN
                </td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="text-uppercase font-weight-bold no-border ps-4">PENERIMAAN</td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="text-uppercase font-weight-bold no-border ps-4">PENERIMAAN PEMBIAYAAN DALAM NEGERI</td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
                <td class="text-right no-border">&nbsp;</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">Penerimaan Pinjaman</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">Penerimaan dan Divestasi</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">Penerimaan Kembali Pinjaman Kepada
                    Pihak Lain</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">Jumlah Penerimaan Pembiayaan</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">&nbsp;</td>
                <td class="font-weight-bold text-center">&nbsp;</td>
                <td class="font-weight-bold text-center">&nbsp;</td>
                <td class="font-weight-bold text-center">&nbsp;</td>
                <td class="font-weight-bold text-center">&nbsp;</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border text-uppercase">Jumlah Penerimaan Pembiayaan</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border text-uppercase">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
                <td class="font-weight-bold text-center no-border">&nbsp;</td>
            </tr>

            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-uppercase font-weight-bold no-border ps-4">Pengeluaran</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="text-uppercase font-weight-bold no-border ps-4">Pengeluaraan Pembiayaan Dalam Negeri</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
                <td class="text-center no-border">&nbsp;</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-center align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">Pembyaran Pokok Pinjaman</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">Pengeluaran Penyertaan Modal</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
                <td class="text-right no-border">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="ps-5 no-border" style="padding-left: 35pt !important;">Pemberian Pinjaman Kepada Pihak Lain
                </td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">Jumlah Penerimaan Pembiayaan Dalam Negeri</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border">&nbsp;</td>
                <td class="font-weight-bold text-right no-border">&nbsp;</td>
                <td class="font-weight-bold text-right no-border">&nbsp;</td>
                <td class="font-weight-bold text-right no-border">&nbsp;</td>
                <td class="font-weight-bold text-right no-border">&nbsp;</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border text-uppercase">Jumlah Pengeluaraan Pembiayaan</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
                <td class="font-weight-bold text-right">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border text-uppercase">Pembiayaan Netto</td>
                <td class="font-weight-bold text-right no-border">0</td>
                <td class="font-weight-bold text-right no-border">0</td>
                <td class="font-weight-bold text-right no-border">0</td>
                <td class="font-weight-bold text-right no-border">0</td>
            </tr>
            <tr style="border-top: hidden">
                <td class="text-right align-middle no-border"></td>
                <td class="text-end font-weight-bold no-border text-uppercase">&nbsp;</td>
                <td class="font-weight-bold text-right">&nbsp;</td>
                <td class="font-weight-bold text-right">&nbsp;</td>
                <td class="font-weight-bold text-right">&nbsp;</td>
                <td class="font-weight-bold text-right">&nbsp;</td>
            </tr>
            <tr class="font-weight-bold " style="border-top: hidden">
                <td class="text-right align-middle"></td>
                <td class="text-end text-uppercase">SILPA</td>
                <td class="text-right no-border">{{ number_format($lra_silpa->Rencana, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ number_format($lra_silpa->Realisasi, 2, ',', '.') }}</td>
                <td class="text-right no-border">{{ $lra_silpa->Rencana == 0 ? 0 : number_format($lra_silpa->Realisasi/$lra_silpa->Rencana*100, 2, ',', '.') }} %</td>
                <td class="text-right no-border">0</td>
            </tr>
        </tbody>
    </table>
</div>