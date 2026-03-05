<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="reportpdf/bootstrap.min.css">

    <title>Permintaan Uang Panjar</title>
  </head>
  <body>
    <div class="row">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td class="text-center">{{ nm_unit() }}</td>
                </tr>
                <tr>
                    <td class="text-center">PERMINTAAN UANG MUKA/PANJAR</td>
                </tr>
                <tr>
                    <td class="text-center"style="font-size: 10pt;">Nomor : {{ $panjar->No_bp}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <table class="table-sm" cellspacing="0" style="font-size: 8pt;">
            <tbody>
                <tr>
                    <td>Tahun Anggaran </td>
                    <td> : </td>
                    <td>{{ Tahun() }}</td>
                </tr>
                <tr>
                    <td>Sub Kegiatan </td>
                    <td> : </td>
                    <td>{{ $kegiatan[0]->Ur_KegBL2 }}</td>
                </tr>
                <tr>
                    <td>Anggaran Tersedia </td>
                    <td> : </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Uraian </td>
                    <td> : </td>
                    <td>{{ $panjar->Ur_bp }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <table class="table table-sm table-striped" cellspacing="0" style="font-size: 8pt">
            <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle;" rowspan="2">No.</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="2">Rekening</th>
                    <th class="text-center" style="vertical-align: middle;" colspan="2">Rencana Kebutuhan Dana</th>   
                </tr>
                <tr>
                    <th class="text-center" style="vertical-align: middle;">Kode</th>
                    <th class="text-center" style="vertical-align: middle;">Uraian</th>
                    <th class="text-center" style="vertical-align: middle;">Rencana Belanja</th>
                    <th class="text-center" style="vertical-align: middle;">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                {{$no=1;}}
                @foreach ($rincian as $item)
                    <tr>
                        <td class="text-center" style="vertical-align: middle;">{{ $no++ }}</td>
                        <td class="text-center" style="vertical-align: middle;">{{ $item->Ko_Rkk }}</td>
                        <td class="text-center" style="vertical-align: middle;">{{ $item->Ur_Rk6 }}</td>
                        <td class="text-center" style="vertical-align: middle;">{{ $item->Ur_bprc }}</td>
                        <td class="text-right" style="vertical-align: middle;">@rupiah($item->To_Rp)</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td class="text-right" colspan="3">Jumlah</td>
                    <td class="text-right" style="vertical-align: middle;">@rupiah($total[0]->jml)</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- <div class="row" style="font-size: 8pt; ">
        <p class="text-right" >{{ ucfirst(nm_ibukota()) }}, {{date("d-m-Y")}}</p> --}}
    </div>
    <div class="row" style="font-size: 8pt;">
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td colspan="3">Setuju diberikan uang muka/panjar</td>
                </tr>
                <tr>
                    <td colspan="3">Sebesar <b>@rupiah($total[0]->jml)</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width: 40%"></td>
                    <td class="text-center">{{ ucfirst(nm_ibukota()) }}, {{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</td>
                </tr>
                <tr>
                    <td class="text-center">Pimpinan BLUD,</td>
                    <td></td>
                    <td class="text-center">PPTK,</td>
                </tr>
                <tr>
                    <td style="height: 8%"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-center">{{ tb_sub('Nm_Pimp')}}</td>
                    <td></td>
                    <td class="text-center">.........................</td>
                </tr>
                <tr>
                    <td class="text-center">NIP {{ tb_sub('NIP_Pimp')}}</td>
                    <td></td>
                    <td class="text-center">.........................</td>
                </tr>
            </tbody>
        </table>
    </div>
  </body>
</html>