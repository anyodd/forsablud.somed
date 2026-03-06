<?php
use Illuminate\Support\Facades\DB;

$units = ['53.08.01.02.01.001','33.05.01.02.01.001','32.03.01.02.01.001'];
foreach($units as $u) {
    echo $u . " NPD: " . DB::table('tb_npd')->where('Ko_unitstr', $u)->count() . "\n";
    echo $u . " SPI (Expenditure): " . DB::table('tb_spirc')->join('tb_spi', 'tb_spirc.id_spi', '=', 'tb_spi.id')->where('tb_spirc.Ko_unitstr', $u)->whereIn('tb_spi.Ko_SPi', [2,3,4,6,8,9])->count() . "\n";
}
