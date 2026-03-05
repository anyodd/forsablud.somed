<table class="table table-bordered table-striped" style="width: 100%" id="example1">
    <thead>
        <tr>
            <th class="text-center" style="width: 3px">No.</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">No.Bukti</th>
            <th class="text-center">Kode Rekening</th>
            <th class="text-center">Uraian</th>
            <th class="text-center">Penerimaan</th>
            <th class="text-center">Pengeluaran</th>
            <th class="text-center">Saldo</th>
        </tr>
    </thead>
    <tbody>
    @php
        $total = 0;
        $total_penerimaan = 0;
        $total_pengeluaran = 0;
    @endphp
    @if (count($data) > 0)
        @foreach ($data as $item)
        <tr>
            <td class="text-center">{{$loop->iteration}}.</td>
            <td class="text-center">{{ date('d M Y', strtotime($item->Tgl_Bukti)) }}</td>
            <td>{{$item->No_Bukti}}</td>
            <td class="text-center">{{$item->Ko_Rkk}}</td>
            <td>{{$item->Ur_bprc}}</td>
            <td class="text-right">{{number_format($item->Terima, 2, ',', '.')}}</td>
            <td class="text-right">{{number_format($item->Keluar, 2, ',', '.')}}</td>
            <td class="text-right">{{number_format($total +=$item->Terima - $item->Keluar, 2, ',', '.')}}</td>
        </tr>
    @php
        $total_penerimaan += $item->Terima;
        $total_pengeluaran += $item->Keluar;
    @endphp
        @endforeach
    @else
        <tr><td colspan="8" style="text-align: center">Data tidak ada</td></tr>  
    @endif
    </tbody>
    <tfoot style="background-color: #1db790">
        <tr>
            <th class="text-center" colspan=5>Total</th>
            <th class="text-right">{{number_format($total_penerimaan, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total_pengeluaran, 2, ',', '.')}}</th>
            <th class="text-right">{{number_format($total, 2, ',', '.')}}</th>
        </tr>
    </tfoot>
</table><br>
<table style="width: 100%" id="terbilang">
    <tbody>
        <tr>
            <td colspan="8">Saldo Kas di Bendahara Penerimaan/Bendahara Penerimaan Pembantu <br>
            </td>
        </tr>
        <tr>
            <td style="width: 3%"></td>
            <td colspan="7">
                Rp. {{number_format($total, 0, ',', '.')}}<br>
                (Terbilang {{ucwords(terbilang($total))}} Rupiah)<br>
                terdiri dari : <br>
                a. Tunai     : Rp. 0,00<br>
                b. Bank      : Rp. ...........<br>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align: center"> 
                <strong>Disetujui oleh,<br>
                    Pengguna Anggara/Kuasa<br>
                    Pengguna Anggaran
                    <br><br><br>
                    {{$pegawai[0]->Nm_Pimp}}<br>
                    NIP. {{$pegawai[0]->NIP_Pimp}}
                <br><br><br></strong> 
            </td>
            <td colspan="4" style="text-align: center"> 
                <strong>Disiapkan oleh,<br>
                    Bendahara Penerimaan/<br>
                    Bendahara Penerimaan Pembantu
                    <br><br><br>
                    {{-- {{$pegawai[0]->Nm_Bend}}<br>
                    NIP. {{$pegawai[0]->NIP_Bend}} --}}
                    @if (!empty($bendahara[0]))
                        {{$bendahara[0]->Nm_Bend}}<br>
                        NIP. {{$bendahara[0]->NIP_Bend}}
                    @else
                        TTD <br>
                        NIP. -
                    @endif
                <br><br><br></strong> 
            </td>
        </tr>
    </tbody>
</table>