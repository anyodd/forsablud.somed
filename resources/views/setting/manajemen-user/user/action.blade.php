<div class="btn-group-sm" role="group">
    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        Aksi
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('setting.manajemen-user.user.form', $user->code) }}" class="dropdown-item" data-toggle="modal"
            data-target="#modal" data-action="password" title="Ganti Password"><i class="fa fa-key fa-fw"></i> Ganti
            Password</a>
        <a href="{{ route('setting.manajemen-user.user.form', $user->code) }}" class="dropdown-item" data-toggle="modal"
            data-target="#modal" data-action="edit" title="Edit User"><i class="fas fa-edit"></i> Edit User</a>
        @if ( getUser('user_level') == '99')
        <a href="{{ route('setting.manajemen-user.user.form', $user->code) }}" class="dropdown-item" data-toggle="modal"
            data-target="#modal" data-action="delete" title="Hapus User"><i class="fa fa-trash"></i> Hapus
            User</a>
        @endif
    </div>
</div>
