<table class="table table-bordered table-striped" id="example1">
  <thead>
      <tr>
          <th class="text-center" style="width: 3px; vertical-align: middle; font-size: 10pt">No</th>
          <th class="text-center" style="vertical-align: middle; font-size: 10pt">Tgl. Bukti</th>
          <th class="text-center" style="vertical-align: middle; font-size: 10pt">No. Bukti</th>
          <th class="text-center" style="vertical-align: middle; font-size: 10pt">Uraian</th>
          <th class="text-right" style="vertical-align: middle; font-size: 10pt">Terima (Rp)</th>
          <th class="text-right" style="vertical-align: middle; font-size: 10pt">Keluar (Rp)</th>
          <th class="text-right" style="vertical-align: middle; font-size: 10pt">Saldo (Rp)</th>
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
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->Tgl_Bukti }}</td>
            <td class="text-center">{{ $item->No_Bukti }}</td>
            <td class="text-left">{{ $item->Uraian }}</td>
            <td class="text-right">{{ number_format($item->Terima, 2, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->Keluar, 2, ',', '.') }}</td>
            <td class="text-right">
                {{ number_format($total += $item->Terima - $item->Keluar,2,',','.') }}
            </td>
        </tr>
        @php
            $total_penerimaan += $item->Terima;
            $total_pengeluaran += $item->Keluar;
        @endphp
        @endforeach
      @else
      <tr>
          <td colspan="6" style="text-align: center">Data tidak ada</td>
      </tr>
      @endif
  </tbody>
  <tfoot style="background-color: #1db790">
    <tr>
        <th class="text-center" colspan=4>Total</th>
        <th class="text-right">{{number_format($total_penerimaan, 2, ',', '.')}}</th> 
        <th class="text-right">{{number_format($total_pengeluaran, 2, ',', '.')}}</th>
        <th class="text-right">{{number_format($total, 2, ',', '.')}}</th>
    </tr>
  </tfoot>
</table><br>

<table style="width: 100%">
  <tbody>
      <tr>
          <td colspan="8">Saldo Kas di Bendahara BLUD <br>
          </td>
      </tr>
      <tr>
          <td style="width: 3%"></td>
          <td colspan="7">
              Rp. {{number_format($total, 2, ',', '.')}}<br>
              (Terbilang {{ ucwords(terbilang($total)) }} Rupiah)<br>
              terdiri dari : <br>
              a. Tunai     : Rp. 0,00<br>
              b. Bank      : Rp. {{number_format($total, 2, ',', '.')}}<br>
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
                  {{$pegawai[0]->Nm_Bend}}<br>
                  NIP. {{$pegawai[0]->NIP_Bend}}
              <br><br><br></strong> 
          </td>
      </tr>
  </tbody>
</table>