@foreach ($transaksi as $item)
    <tr>
        <td class="text-center">{{ $loop->iteration }}.</td>
        <td>{{ $item->Ko_sKeg1 }}</td>
        <td>{{ $item->Ko_sKeg2 }}</td>
        <td>{{ $item->No_bp }}</td>
        <td>{{ $item->dt_rftrbprc }}</td>
        <td>{{ $item->Ur_bprc }}</td>
        <td>{{ $item->Ko_Rkk }}</td>
        <td class="text-right">{{ number_format($item->spirc_Rp,2,',','.') }}</td>
        <td>
            <button class="btn btn-xs btn-warning py-0" title="Pilih Data" id="transaksi" data-dismiss="modal"
            data-nobp    = {{$item->No_bp}}
            data-kobprc  = {{$item->Ko_bprc}}
            data-skeg1   = {{$item->Ko_sKeg1}}
            data-skeg2   = {{$item->Ko_sKeg2}}
            data-urkegs1 = {{$item->Ur_KegBL1}}
            data-urkegs2 = {{$item->Ur_KegBL1}}
            data-korkk   = {{$item->Ko_Rkk}}
            data-urkk    = {{$item->Ur_Rk6}} >
                <i class="fas fa-check-alt"></i> Pilih
            </button>
        </td>
    </tr>
@endforeach