<div class="tab-pane fade show" id="registerSpm" role="tabpanel" aria-labelledby="registerSpm-tab">
    <a href="" id="scroll" style="display: none;"><span></span></a>
    <table class="table" style="width: 100%">
        <thead>
            <tr>
                <td class="text-center text-bold" colspan="12" style="border: none">
                    REGISTER S-OPD<br>
                    TAHUN ANGARAN {{ Tahun() }} <br>
                    Periode <br>
                    <input type="text" style='text-align: center' name="daterange" value="" />
                </td>
            </tr>
        </thead>
    </table>
    <div id="result-table" class="container result-table" style="width: 100%"></div>
    <table class="table table-bordered table-striped table-header" id="table-header" style="width: 100%">
        <thead>
            <tr>
                <th rowspan="2" class="text-center" style="vertical-align: middle;width: 3px">No.</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Tanggal</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Nomor</th>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">Uraian</th>
                <th colspan="3" class="text-center" style="vertical-align: middle;">Jumlah</th>
            </tr>
            <tr>
                <th class="text-center">UP</th>
                <th class="text-center">GU</th>
                <th class="text-center">LS</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center baris-kosong" id='baris-kosong' colspan=7>Silahkan Pilih Periode Pelaporan</td>
                <td class="text-center baris-loader" id='baris-loader' colspan=7>
                    <div class="lds-ellipsis"><div></div><div></div><div></div></div>
                </td>
            </tr>
        </tbody>
    </table><br><br>
    <table style="width: 100%">
        <tbody>
            <td colspan="4" style="text-align: center">
                <strong><br><br>
                    Mengetahui,<br>
                    Pemimpin BLUD
                    <br><br><br>
                    Nama<br>
                    NIP. ............
                    <br><br><br>
                </strong>
            </td>
            <td colspan="4" style="text-align: center">
                <strong>
                    {{ nm_ibukota() }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }} <br><br><br>
                    Pejabat Keuangan BLUD
                    <br><br><br>
                    Nama<br>
                    NIP. ............
                    <br><br><br>
                </strong>
            </td>
        </tbody>
    </table>
</div>