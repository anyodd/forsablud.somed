<tr style="border-bottom: double">
    <td colspan="2" style="padding-left: 0; padding-bottom:0">
        @if (!empty(logo_pemda()))
            <img src="{{ public_path('logo/pemda/').logo_pemda() }}" alt="Logo Kemenkes" style="width: 60px;height: 70px">
        @else
            <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
        @endif
    </td>
    <td class="text-center text-bold" colspan="4" style="; padding-bottom:0">
        <p style="font-size: 16pt; margin-bottom: 0; margin-top: 0; font-weight: lighter">PEMERINTAH {{
            strtoupper(nm_pemda()) }}</p>
        {{-- <p class="text-bold" style="font-size: 15pt; margin-bottom: 0; margin-top: 0">Rumah Sakit Umum Daerah</p> --}}
        {{-- <p class="text-bold" style="font-size: 15pt; margin-bottom: 0; margin-top: 0">{{ explode(' ', nm_unit())[1] . '' . explode(' ', nm_unit())[2] }}</p> --}}
        <p class="text-bold" style="font-size: 15pt; margin-bottom: 0; margin-top: 0">{{ nm_unit() }}</p>
        <p style="margin-bottom: 0; margin-top: 0; font-weight: lighter">{{ tb_sub('Nm_Jln') }}</p>
    </td>
    <td colspan="2" class="text-right" style="padding-right: 0; padding-bottom:0">
        @if (!empty(logo_blud()))
            <img src="{{ public_path('logo/blud/').logo_blud() }}" alt="Logo RS" style="width: 60px;height: 70px">
        @else
            <img src="{{ public_path('template/dist/img/transparent.png') }}" alt="Logo RS" style="width: 60px;height: 70px">
        @endif
    </td>
</tr>