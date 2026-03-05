<div class="btn-group-sm" role="group">
    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        Aksi
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('setting.manajemen-pemda.form', $pemda->code) }}" class="dropdown-item" data-toggle="modal"
            data-target="#modal" data-action="edit" title="Edit Pemda"><i class="fas fa-edit"></i> Edit Pemda</a>
        <a href="{{ route('setting.manajemen-pemda.form', $pemda->code) }}" class="dropdown-item" data-toggle="modal"
            data-target="#modal" data-action="delete" title="Hapus Pemda"><i class="fa fa-trash"></i> Hapus
            Pemda</a>
    </div>
</div>
