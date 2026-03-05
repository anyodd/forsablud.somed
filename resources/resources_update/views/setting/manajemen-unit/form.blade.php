@php
if ($action == 'edit') {
    $route = ['setting.manajemen-unit.update', [$model->code, 'table' => $table]];
    $method = 'PUT';
	$readonly = 'readonly';
} elseif ($action == 'delete') {
    $route = ['setting.manajemen-unit.destroy', [$model->code, 'table' => $table]];
    $method = 'DELETE';
} elseif ($action == 'wizard') {
    $route = ['setting.manajemen-unit.wizard', [$model->code]];
    $method = 'POST';
} else {
    $route = ['setting.manajemen-unit.store', ['table' => $table]];
    $method = 'POST';
	$readonly = 'readonly';
}
@endphp
{!! Form::model($model, [
    'class' => 'form needs-validation',
    'id' => 'form',
    'method' => $method,
    'route' => $route,
    'autocomplete' => 'off',
    'novalidate',
]) !!}
@if ($action == 'delete')
    <div class="text-center">
        <h1 class=" text-danger"><i class="fa fa-trash"></i></h1>
        <h3 class=" text-30 text-danger">Hapus Data</h3>
        <p>Apakah anda yakin untuk <b class="text-danger">menghapus</b> data <br><strong>
		@if ($table == 'Unit')
			{{ $model->{'Ur_'.$table} }}
			@else
				{{ $model->{'ur_subunit'} }}
		@endif
                ?</strong>
            <hr><small><i>Data yang sudah dihapus tidak dapat dikembalikan</i></small>
        </p>
    </div>
    <div class="modal-footer justify-content-center">
        {!! Form::button('<i class="fa fa-trash"></i> Hapus', ['type' => 'submit', 'class' => 'btn btn-danger waves-effect waves-light']) !!}
        <button type="button" class="btn btn-secondary waves-effect waves-light" data-dismiss="modal"><i
                class="fa fa-times"></i> Batal</button>
    </div>
@elseif ($action == 'wizard')
    @include('setting.manajemen-unit.wizard')
@else
    @if ($action == 'create' || $table == 'Sub')
        {!! Form::hidden($foreignKey, $foreignId) !!}
		{!! Form::hidden('id_pemda', $id_pemda) !!}
		{!! Form::hidden('Ko_Wil1', 0) !!}
		{!! Form::hidden('Ko_Wil2', 0) !!}
		{!! Form::hidden('Ko_Urus', 0) !!}
		{!! Form::hidden('Ko_Bid', 0) !!}
		{!! Form::hidden('Ko_Unit', 0) !!}
		
        @if ($table == 'Unit')
            {!! Form::hidden('id_pemda', $id_pemda) !!}
		
        @endif
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12">
				<div class="form-group row">
					{!! Form::label('Ko_Period', 'Tahun Anggaran:', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
					<div class="col-sm-9">
						{!! Form::text('Ko_Period', $tahun ?? Tahun() , [
							'class' => 'form-control',
							'id' => 'Ko_Period',
							'required',
							$readonly,
						]) !!}
					</div>
				</div>
                <div class="form-group row">
                    {!! Form::label('Ko_'.$table, 'Kode '.$labelName.' :', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
                    <div class="col-sm-1">
                        {!! Form::number('Ko_'.$table, $model->{'Ko_'.$table} ?? $modelClass::where($foreignKey, $foreignId)->max('Ko_'.$table) + 1, [
                            'class' => 'form-control',
                            'id' => 'Ko_'.$table,
                            'required',
                        ]) !!}
                    </div>
                </div>
				@if ($table == 'Unit')
					<div class="form-group row">
						{!! Form::label('Ur_'.$table, 'Nama '.$labelName.' :', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
						<div class="col-sm-9">
							{!! Form::text('Ur_'.$table, null, [
								'class' => 'form-control',
								'id' => 'Ur_'.$table,
								'required',
							]) !!}
						</div>
					</div>
					@else
					<div class="form-group row">
						{!! Form::label('ur_subunit', 'Nama '.$labelName.' :', ['class' => 'col-sm-3 col-form-label text-left font-weight-semibold border-bottom']) !!}
						<div class="col-sm-9">
							{!! Form::text('ur_subunit', null, [
								'class' => 'form-control',
								'id' => 'ur_subunit',
								'required',
							]) !!}
						</div>
					</div>
				@endif
                <div class="form-group row">
                    <div class="col-12 text-right">
                        {!! Form::button('<i class="fa fa-save"></i> Simpan', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
                        {!! Form::button('<i class="fa fa-times"></i> Batal', ['type' => 'button', 'class' => 'btn btn-secondary ml-1', 'data-dismiss' => 'modal']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
{!! Form::close() !!}
