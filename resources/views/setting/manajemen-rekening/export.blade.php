@extends('export.app')

@push('styles')
    <style type="text/css">
        .kode {
            width: 110px;
        }

        .saldo-normal {
            width: 100px;
        }

        .peraturan {
            width: 200px;
        }
    </style>
@endpush

@section('content')
    @php $colspan = 6 @endphp
    <table class="table-export">
        <thead>
            <tr>
                <th class="kode">KODE REKENING</th>
                <th colspan="{{ $colspan }}">URAIAN</th>
                <th>SALDO NORMAL</th>
                <th>PERATURAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($Rekening as $rek)
            <tr>
                <td class="kode">{{ $rek->Ko_Rk }}</td>
                @for ($i = 0; $i < $colspan; $i++)
                    @if (substr_count($rek->Ko_Rk, '.') == $i)
                        @if ($i < 3)
                            <td colspan="{{ $colspan - $i }}"><strong>{{ $rek->nmrek }}</strong></td>
                        @else
                            <td colspan="{{ $colspan - $i }}">{{ $rek->nmrek }}</td>
                        @endif
                        @php $i += $colspan @endphp
                    @else
                        <td class="border-none"></td>
                    @endif
                @endfor
                <td class="saldo-normal">{{ $rek->saldo_normal }}</td>
                <td class="peraturan"></td>
            </tr>
            @empty
            <tr>
                <td>Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="9"></th>
            </tr>
        </tfoot>
    </table>
@endsection
