<?php
use Illuminate\Support\Facades\DB;

$unit = '13.77.01.02.01.001';
$period = 2026;
$bulan = 12;

echo "Tracing Realization for RSUD Sadikin 2026...\n";

// OLD LOGIC (Simplified)
$queryOld = "
    SELECT SUM(A.spirc_Rp) as total
    FROM tb_spirc A 
    INNER JOIN tb_spi B ON A.id_spi = B.id 
    INNER JOIN tb_oto C ON B.id = C.id_spi 
    INNER JOIN tb_npd D ON C.id = D.id_oto 
    INNER JOIN (SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
    WHERE A.Ko_unitstr = '$unit' AND A.Ko_Period = $period AND B.Ko_SPi IN (2,3,4,6,8,9)
";

$old = DB::select($queryOld);
echo "Old Logic Total: " . ($old[0]->total ?? 0) . "\n";

// NEW LOGIC (Including tb_bp)
$queryNew = "
    SELECT SUM(t.nilai) as total
    FROM (
        SELECT A.spirc_Rp as nilai
        FROM tb_spirc A 
        INNER JOIN tb_spi B ON A.id_spi = B.id 
        INNER JOIN tb_oto C ON B.id = C.id_spi 
        INNER JOIN tb_npd D ON C.id = D.id_oto 
        INNER JOIN (SELECT id_npd, No_npd, dt_byro FROM tb_byroto GROUP BY id_npd, No_npd, dt_byro ) E ON D.id_npd = E.id_npd
        WHERE A.Ko_unitstr = '$unit' AND A.Ko_Period = $period AND B.Ko_SPi IN (2,3,4,6,8,9)
        UNION ALL
        SELECT A.To_Rp as nilai
        FROM tb_bprc A 
        INNER JOIN tb_bp B ON A.id_bp = B.id_bp
        WHERE B.Ko_unitstr = '$unit' AND B.Ko_Period = $period AND B.Ko_bp IN (4,5)
    ) t
";

$new = DB::select($queryNew);
echo "New Logic Total: " . ($new[0]->total ?? 0) . "\n";
