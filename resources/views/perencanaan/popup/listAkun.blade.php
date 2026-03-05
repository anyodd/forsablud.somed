<div class="modal fade" id="modal-listAkun">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Akun</h4>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered table-hover dtable">
                <thead>
                    <tr>
                    <th>Kode Akun</th>
                    <th>Uraian</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ls as $item)
                        <tr>
                            {{-- <td style="width: 10%">{{ sprintf('%02d',$item->Ko_Rk1).'.'. sprintf('%02d',$item->Ko_Rk2).'.'. sprintf('%02d',$item->Ko_Rk3).'.'. sprintf('%02d',$item->Ko_Rk4).'.'. sprintf('%03d',$item->Ko_Rk5).'.'. sprintf('%03d',$item->Ko_Rk6) }}</td> --}}
                            <td style="width: 10%">{{ $item->Ko_RKK }}</td>
                            <td>{{ $item->Ur_Rk6 }}</td>
                            <td  class="text-center" style="width: 5%">
                                <button class="btn btn-sm btn-outline-primary" id="select" data-dismiss="modal"
                                    data-rk1 = "{{ $item->Ko_Rk1 }}"
                                    data-rk2 = "{{ $item->Ko_Rk2 }}"
                                    data-rk3 = "{{ $item->Ko_Rk3 }}"
                                    data-rk4 = "{{ $item->Ko_Rk4 }}"
                                    data-rk5 = "{{ $item->Ko_Rk5 }}"
                                    data-rk6 = "{{ $item->Ko_Rk6 }}"
                                    data-ur_rk6 = "{{ $item->Ur_Rk6 }}"
                                ><i class="far fa-check-circle"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
              
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        </div>
      </div>
    </div>
</div>  