<div class="btn-group-sm" role="group">
    @if ($info['hasDetail'])
        <button type="button" class="btn btn-warning tab-detail" data-code="{{ $model->code }}"
            data-target="{{ $info['targetDetail'] }}" data-toggle="tooltip" title="lihat {{ $info['labelDetail'] }}"><i
                class="fas fa-list"></i></button>
    @endif
    <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        Aksi
    </button>
    @if ($info['hasNext'])
        <button type="button" class="btn btn-sm btn-success btn-next " data-toggle="tooltip"
            title="Lihat {{ $info['labelNext'] }}"><i class="fas fa-forward"></i>
		</button>
    @endif
    <div class="dropdown-menu">
		<a href="{{ route('setting.manajemen-unit.form', ['code' => $model->code, 'table' => $table]) }}"
			class="dropdown-item" data-toggle="modal" data-target="#modal" data-action="edit"
			title="Edit {{ $info['labelName'] }}"><i class="ti-pencil"></i> Edit {{ $info['labelName'] }}
		</a>
		<a href="{{ route('setting.manajemen-unit.form', ['code' => $model->code, 'table' => $table]) }}"
			class="dropdown-item" data-toggle="modal" data-target="#modal" data-action="delete"
			title="Hapus {{ $info['labelName'] }}"><i class="ti-trash"></i> Hapus
			{{ $info['labelName'] }}
		</a>
    </div>
</div>
