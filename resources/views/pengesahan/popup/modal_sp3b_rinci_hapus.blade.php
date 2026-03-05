 <div class="modal fade" id="modal{{ $sp3brinci->id_sp3rc }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Yakin mau hapus dokumen Rincian SP3B No: {{ $sp3brinci->No_sp3 }} <br>
         No Otorisasi: {{ $sp3brinci->No_oto }} <br>
         senilai Rp {{ number_format($sp3brinci->sp3rc_Rp, 0, ',', '.') }} ?</h6>
      </div>
      <div class="modal-footer">
        <form action="{{ route('sp3b_rinci_destroy', $sp3brinci->id_sp3rc) }}" method="post" class="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger mr-3" name="submit" title="Hapus">Ya, Hapus
          </button>
        </form>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
      </div>
    </div>
  </div>
</div>