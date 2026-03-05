<div class="modal fade" id="modal{{ $keg->id }}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Konfirmasi :</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Yakin mau hapus data Kegiatan: {{ $keg->Ur_sKeg }} ?</h6>
      </div>
      <div class="modal-footer">
        <form action="{{ route('setkegiatan.destroy', $keg->id) }}" method="post" class="">
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