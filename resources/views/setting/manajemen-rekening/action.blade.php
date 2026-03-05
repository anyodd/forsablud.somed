<div class="btn-group" role="group">
        <a href="{{ route('setting.manajemen-rekening.form', ['Ko_Rk' => $info['parentRk'] . '.' . $Ko_Rk]) }}"
            class="btn btn-warning" data-toggle="modal" data-target="#modal" data-action="edit" title="Edit Rekening">
            <i class="fas fa-pencil-alt"></i>
        </a>
        <a href="{{ route('setting.manajemen-rekening.form', ['Ko_Rk' => $info['parentRk'] . '.' . $Ko_Rk]) }}"
            class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal" data-action="delete"
            title="Hapus Rekening">
            <i class="fas fa-trash fa-fw"></i>
        </a>
    @if ($info['nextLabel'])
        <button type="button" class="btn btn-sm btn-success btn-tab-next" title="Lihat {{ $info['nextLabel'] }}">
            <i class="fas fa-forward"></i>
        </button>
    @endif
</div>
