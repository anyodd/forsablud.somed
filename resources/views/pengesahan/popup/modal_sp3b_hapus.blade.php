 <div class="modal fade" id="modalHapus{{$sp3b->id_sp3}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi :</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Yakin mau hapus dokumen SP3B: {{ $sp3b->No_sp3 }} ?</h6>
      </div>
      <div class="modal-footer">
        <form action="{{ route('pengesahan.destroy', $sp3b->id_sp3) }}" method="post" class="">
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