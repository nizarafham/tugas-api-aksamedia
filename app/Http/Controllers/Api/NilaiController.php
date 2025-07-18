<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function hitungNilaiRT()
    {
        $queryRT = "
            SELECT
                nisn,
                nama,
                nama_pelajaran,
                soal_benar
            FROM
                nilai
            WHERE
                materi_uji_id = 7
                AND nama_pelajaran != 'pelajaran_khusus'
        ";

        $hasilMentahSql = DB::connection('mysql_nilai')->select($queryRT);
        $dataSiswaDikelompokkan = collect($hasilMentahSql)->groupBy('nisn');

        $hasilAkhir = $dataSiswaDikelompokkan->map(function ($nilaiPerSiswa, $nisn) {
            $detailSiswa = $nilaiPerSiswa->first();

            $objekNilaiRt = $nilaiPerSiswa->pluck('soal_benar', 'nama_pelajaran');

            return [
                'nama' => $detailSiswa->nama,
                'nilaiRt' => $objekNilaiRt,
                'nisn' => $nisn,
            ];
        });

        return response()->json($hasilAkhir->values());
    }

    public function hitungNilaiST()
    {
        $queryST = "
            SELECT
                nisn,
                nama,
                nama_pelajaran,
                (
                    CASE
                        WHEN pelajaran_id = 44 THEN skor * 41.67
                        WHEN pelajaran_id = 45 THEN skor * 29.67
                        WHEN pelajaran_id = 46 THEN skor * 100.0
                        WHEN pelajaran_id = 47 THEN skor * 23.81
                        ELSE 0
                    END
                ) AS skor_tertimbang
            FROM
                nilai
            WHERE
                materi_uji_id = 4
        ";

        $hasilMentahSql = DB::connection('mysql_nilai')->select($queryST);

        $dataSiswaDikelompokkan = collect($hasilMentahSql)->groupBy('nisn');

        $hasilAkhir = $dataSiswaDikelompokkan->map(function ($nilaiPerSiswa, $nisn) {
            $detailSiswa = $nilaiPerSiswa->first();

            $objekListNilai = $nilaiPerSiswa->pluck('skor_tertimbang', 'nama_pelajaran')
                ->map(fn($skor) => round($skor, 2));

            $totalNilai = $objekListNilai->sum();

            return [
                'listNilai' => $objekListNilai,
                'nama' => $detailSiswa->nama,
                'nisn' => $nisn,
                'total' => $totalNilai,
            ];
        });

        $hasilDiurutkan = $hasilAkhir->sortByDesc('total');

        return response()->json($hasilDiurutkan->values());
    }
}
