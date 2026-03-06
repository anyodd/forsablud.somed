<?php
use Illuminate\Support\Facades\DB;

$unit = '16.00.01.02.01.001.001';
$period = 2026;

$id_tap = DB::table('tb_tap')->where(['Ko_Period' => $period, 'ko_unit1' => $unit])->max('id_tap');
$bidang = 3;

echo "FINAL LOGIC (Deduplicated A + id_bidang filter):\n";
$final = DB::select("
    SELECT A.Ko_Rkk, B.ur_rk6, SUM(A.to_rp) AS to_rp
    FROM (
        SELECT DISTINCT ko_period, ko_unit1, id_tap, ko_skeg1, ur_kegbl1, ko_skeg2, ur_kegbl2, Ko_Pdp, ko_rkk, ur_rk6, To_Rp
        FROM tb_tap
        WHERE ko_period = $period AND ko_unit1 = '$unit'
    ) A 
    INNER JOIN pf_rk6 B ON A.Ko_Rkk = B.Ko_Rkk AND A.ur_rk6 = B.ur_rk6
    WHERE A.id_tap = $id_tap
    AND B.id_bidang = $bidang
    GROUP BY A.Ko_Rkk, B.ur_rk6
    LIMIT 10
");
echo json_encode($final, JSON_PRETTY_PRINT) . "\n";
