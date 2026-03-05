@foreach ($rekening as $item)
    <tr>
        <td class="text-center" style="width: 3%">{{ $loop->iteration }}.</td>
        <td style="width: 15%">{{ $item->Ko_RKK }}</td>
        <td>{{ $item->Ur_Rk6 }}</td>
        <td class="text-center" style="width: 8%">
            <button class="btn btn-xs btn-warning py-0" title="Pilih Data" id="rekening" data-dismiss="modal"
            data-korkk = {{$item->Ko_RKK}}>
                <i class="fas fa-check-alt"></i> Pilih
            </button>
        </td>
    </tr>
@endforeach