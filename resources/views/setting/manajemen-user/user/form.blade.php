@php
    if ($action == 'edit') {
        $route = ['setting.manajemen-user.user.update', $user->code];
        $method = 'PUT';
        $title = 'Edit User';
        $password = false;
        $disabled = '';
        $level = $user->level;
    } else if ($action == 'password') {
        $route = ['setting.manajemen-user.user.password', $user->code];
        $method = 'POST';
        $title = 'Ganti Password';
        $password = true;
        $disabled = 'disabled';
        $level = $user->level;
    } else if ($action == 'delete') {
        $route = ['setting.manajemen-user.user.destroy', $user->code];
        $method = 'DELETE';
        $title = 'Hapus User';
    } else {
        $route = ['setting.manajemen-user.user.store'];
        $method = 'POST';
        $title = 'Tambah User';
        $password = true;
        $disabled = '';
        $level = 'operator';
    }
@endphp
{!! Form::model($user, [
    'class' => 'form needs-validation',
    'id' => 'form',
    'method' => 'POST',
    'route' => $route,
    'autocomplete' => 'off',
    'novalidate',
]) !!}
    {!! Form::hidden('_method', $method) !!}
    @if ($action == 'delete')
        <div class="text-center">
            <h4 class="modal-title w-100">Anda Yakin?</h4>
			<div class="modal-body">
				<p>Apakah anda yakin untuk menghapus user atas nama <strong>{{ $user->username }}</strong>? Data yang sudah dihapus tidak dapat dikembalikan.</p>
			</div>
			<div class="modal-footer justify-content-center">
				{!! Form::button('<i class="fa fa-trash"></i> Hapus', ['type' => 'submit', 'class' => 'btn btn-danger waves-effect waves-light']) !!}
				<button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
			</div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-2 justify-content-center">
                    <img src="{{ asset('template') }}/dist/img/icon_login/profile.png" alt="user" class="rounded-circle" width="100%">
                </div>
                <div class="col-10">
                    <div class="form-group row p-2">
                        {!! Form::label('username', 'Nama User', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::text('username', null, [
                                'class' => 'form-control',
                                'id' => 'user_name',
                                'required',
                                $disabled,
                                'maxlength' => 50,
                            ]) !!}
                        </div>
                    </div>
                    @if ($password)
                        <div class="form-group row p-2">
                            {!! Form::label('password', 'Password', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                            <div class="col-sm-9">
                                {!! Form::password('password', [
                                    'class' => 'form-control',
                                    'id' => 'password',
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row p-2">
                            {!! Form::label('password_confirmation', 'Konfirmasi Password', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                            <div class="col-sm-9">
                                {!! Form::password('password_confirmation', [
                                    'class' => 'form-control',
                                    'id' => 'password_confirmation',
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    @endif
                    <div class="form-group row p-2">
                        {!! Form::label('email', 'Email', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::textarea('email', null, [
                                'class' => 'form-control',
                                'id' => 'email',
                                $disabled,
                                'rows' => 4,
                                'maxlength' => 50,
                            ]) !!}
                        </div>
                    </div>
                    @if ( getUser('user_level') == '99')
                    <div class="form-group row p-2">
                        {!! Form::label('user_level', 'Level User', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('user_level', [
                                '1' => 'Admin',
                                '2' => 'Otorisator - Pimpinan',
                                '3' => 'Sekretaris Pimpinan',
                                '4' => 'Operator-Keuangan',
                                '5' => 'Operator-Dinas',
                                '6' => 'Operator-PPTK',
                                '7' => 'Operator-Bendahara',
                                '8' => 'Operator-Pembukuan',
                                '9' => 'Operator-Laporan',
                                '10' => 'Operator-Perencana',
                                '98' => 'Perwakilan',
                                '99' => 'Rendal',
                            ], $level, [
                                'class' => 'form-control select2',
                                'id' => 'user_level',
                                'required',
                                $disabled,
                            ]) !!}
                        </div>
                    </div>
                    @else 
                    <div class="form-group row p-2">
                        {!! Form::label('user_level', 'Level User', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('user_level', [
                                '1' => 'Admin',
                                '2' => 'Otorisator - Pimpinan',
                                '3' => 'Sekretaris Pimpinan',
                                '4' => 'Operator-Keuangan',
                                '5' => 'Operator-Dinas',
                                '6' => 'Operator-PPTK',
                                '7' => 'Operator-Bendahara',
                                '8' => 'Operator-Pembukuan',
                                '9' => 'Operator-Laporan',
                                '10' => 'Operator-Perencana',
                                '98' => 'Perwakilan',
                            ], $level, [
                                'class' => 'form-control select2',
                                'id' => 'user_level',
                                'required',
                                $disabled,
                            ]) !!}
                        </div>
                    </div>
                    @endif
                    <div class="form-group row p-2">
                        {!! Form::label('status', 'Status User', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            <div class="custom-control custom-radio custom-control-inline">
                                {!! Form::radio('status', '1', false, [
                                    'class' => 'custom-control-input curs-point',
                                    'id' => 'active',
                                    $disabled,
                                ]) !!}
                                {!! Form::label('active', 'Aktif', ['class' => 'custom-control-label curs-point']) !!}
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                {!! Form::radio('status', '0', true, [
                                    'class' => 'custom-control-input curs-point',
                                    'id' => 'inactive',
                                    $disabled,
                                ]) !!}
                                {!! Form::label('inactive', 'Tidak Aktif', ['class' => 'custom-control-label curs-point']) !!}
                            </div>
                        </div>
                    </div>
                    @if ( getUser('user_level') == '99')
                    <div class="form-group row p-2">
                        {!! Form::label('Ko_Wil1', 'Provinsi', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('Ko_Wil1', $provinsi, $user->unitAktif()->Ko_Wil1 ?? null, [
                                'class' => 'form-control select2',
                                'id' => 'Ko_Wil1',
                                'required',
                                $disabled,
                            ]) !!}
                        </div>
                    </div>
                    @else 
                    <div class="form-group row p-2">
                       {!! Form::hidden('Ko_Wil1', 'Provinsi', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                    </div>
                    @endif
					<div class="form-group row p-2">
                        {!! Form::label('id_pemda', 'Pemerintah Daerah', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('id_pemda', $pemda, $user->unitAktif()->id_pemda ?? null, [
                                'class' => 'form-control select2',
                                'id' => 'id_pemda',
                                'required',
                                $disabled,
                            ]) !!}
                        </div>
                    </div>
					<div class="form-group row p-2">
                        {!! Form::label('id_unit', 'Nama Unit', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('id_unit', $unit, $user->unitAktif()->id_unit ?? null, [
                                'class' => 'form-control select2',
                                'id' => 'id_unit',
                                'required',
                                $disabled,
                            ]) !!}
                        </div>
                    </div>
					<div class="form-group row p-2">
                        {!! Form::label('id_sub', 'Nama BLUD', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('id_sub', $subunit, $user->subunitAktif()->id_sub ?? null, [
                                'class' => 'form-control select2',
                                'id' => 'id_sub',
                                'required',
                                $disabled,
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row p-2">
                        {!! Form::label('id_sub1', 'Nama Bidang', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                        <div class="col-sm-9">
                            {!! Form::select('id_sub1', $subunit1, $user->subunit1Aktif()->id_sub1 ?? null, [
                                'class' => 'form-control select2',
                                'id' => 'id_sub1',
                                'required',
                                $disabled,
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row p-2">
                        <div class="col-12 text-right">
                            {!! Form::button('<i class="fa fa-save"></i> Simpan', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                            {!! Form::button('<i class="fa fa-times"></i> Batal', ['type' => 'button', 'class' => 'btn btn-secondary ml-2', 'data-dismiss' => 'modal']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
{!! Form::close() !!}

@section('script')  
<script>
  $(function () {
    $('.select2').select2();
  })
</script>
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

@endsection
