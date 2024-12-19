<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\Rangking;
use App\Models\SubKriteria;

class NilaiController extends Controller
{


    public function CalculateCopras()
    {
        $nilaiNormalisasi = [];
        $latestPeriode = Alternatif::max('periode');
        $alternatifs = Alternatif::where('periode', $latestPeriode)->get();
        $kriterias = Kriteria::all();

        foreach ($alternatifs as $alternatif) {
            foreach ($kriterias as $kriteria) {
                $subkriterias = SubKriteria::where('kriteria_id', $kriteria->id)->get(); // Mengambil subkriteria berdasarkan kriteria_id
                foreach ($subkriterias as $subkriteria) {
                    $totalBobotSubKriteria = Nilai::join('subkriteria', 'nilai.subkriteria_id', '=', 'subkriteria.id')
                        ->where('subkriteria.kriteria_id', $kriteria->id)
                        ->sum('subkriteria.bobot');
                    $nilai = Nilai::where([
                        'alternatif_id' => $alternatif->id,
                        'subkriteria_id' => $subkriteria->id
                    ])->first();

                    if ($nilai && $totalBobotSubKriteria > 0) {
                        $nilaiNormalisasi[] = [
                            'alternatif_id' => $alternatif->id,
                            'nama_alternatif' => $alternatif->nama_alternatif,
                            'kriteria_id' => $kriteria->id,
                            'subkriteria_id' => $subkriteria->id,
                            'bobot' => $subkriteria->bobot,
                            'total' => $totalBobotSubKriteria,
                            'nilai_normalisasi' => round($subkriteria->bobot / $totalBobotSubKriteria, 3)
                        ];
                    }
                }
            }
        }

        $nilaiBobotNormalisasi = [];
        foreach ($nilaiNormalisasi as $nilai) {
            $kriteria = Kriteria::find($nilai['kriteria_id']);
            if ($subkriteria) {
                $nilaiBobotNormalisasi[] = [
                    'alternatif_id' => $nilai['alternatif_id'],
                    'nama_alternatif' => $nilai['nama_alternatif'],
                    'subkriteria_id' => $nilai['subkriteria_id'],
                    'kriteria_id' => $nilai['kriteria_id'],
                    'nilai_normalisasi' => $nilai['nilai_normalisasi'],
                    "bobot" => $kriteria->bobot,
                    'nilai_bobot_normalisasi' => round($nilai['nilai_normalisasi'] * $kriteria->bobot, 3)
                ];
            }
        }
        $totalNilaiMaksBenefit = [];
        $totalNilaiMinCost = [];
        $sumMinCostAll = 0;
        foreach ($nilaiBobotNormalisasi as $nilai) {
            $kriteria = Kriteria::find($nilai['kriteria_id']);
            if ($kriteria->tipe == 'Benefit') {
                if (!isset($totalNilaiMaksBenefit[$nilai['alternatif_id']])) {
                    $totalNilaiMaksBenefit[$nilai['alternatif_id']] = [
                        'alternatif_id' => $nilai['alternatif_id'],
                        'nama_alternatif' => $nilai['nama_alternatif'],
                        'total_normalisasi' => 0
                    ];
                }
                $totalNilaiMaksBenefit[$nilai['alternatif_id']]['total_normalisasi'] += round($nilai['nilai_bobot_normalisasi'], 3);
            } elseif ($kriteria->tipe == 'Cost') {
                if (!isset($totalNilaiMinCost[$nilai['alternatif_id']])) {
                    $totalNilaiMinCost[$nilai['alternatif_id']] = [
                        'alternatif_id' => $nilai['alternatif_id'],
                        'nama_alternatif' => $nilai['nama_alternatif'],
                        'total_normalisasi' => 0
                    ];
                }
                $totalNilaiMinCost[$nilai['alternatif_id']]['total_normalisasi'] += round($nilai['nilai_bobot_normalisasi'], 3);

                $sumMinCostAll += round($nilai['nilai_bobot_normalisasi'], 3);
            }
        }

        $bobotRelatif = [];
        $totalBobotRelatif = 0;
        foreach ($totalNilaiMinCost as $key => $value) {
            $bobotRelatif[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'nama_alternatif' => $value['nama_alternatif'],
                'bobot_relatif' => round(1 / $value['total_normalisasi'], 3),
            ];
            $totalBobotRelatif += round(1 / $value['total_normalisasi'], 3);
        }

        $MultipleTotalBobotRelatifAndMinCost = [];
        foreach ($totalNilaiMinCost as $key => $value) {
            $MultipleTotalBobotRelatifAndMinCost[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'nama_alternatif' => $value['nama_alternatif'],
                'total' => round($value['total_normalisasi'] * $totalBobotRelatif, 3),
            ];
        }

        $DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost = [];
        foreach ($MultipleTotalBobotRelatifAndMinCost as $key => $value) {
            $DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'nama_alternatif' => $value['nama_alternatif'],
                'total' => round($sumMinCostAll / $value['total'], 3),
            ];
        }

        $totalQmax = [];
        foreach ($DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost as $key => $value) {
            if (isset($totalNilaiMaksBenefit[$value['alternatif_id']])) {
                $totalQmax[$key] = [
                    'alternatif_id' => $value['alternatif_id'],
                    'nama_alternatif' => $value['nama_alternatif'],
                    'maksbenefit' => round($totalNilaiMaksBenefit[$value['alternatif_id']]['total_normalisasi'], 3),
                    'total' => round($value['total'] + $totalNilaiMaksBenefit[$value['alternatif_id']]['total_normalisasi'], 3),
                ];
            }
        }

        $QMax = max(array_column($totalQmax, 'total'));
        $UIValue = [];
        foreach ($totalQmax as $key => $value) {
            $UIValue[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'nama_alternatif' => $value['nama_alternatif'],
                'value' => ($value['total'] / $QMax) * 100
            ];
        }


        // dd($UIValue);
        foreach ($UIValue as $value) {
            Rangking::updateOrCreate(
                ['alternatif_id' => $value['alternatif_id']],
                ['nilai' => $value['value']]
            );
        }
    }

    public function index()
    {
        $latestPeriode = Alternatif::max('periode');
        $alternatifs = Alternatif::where('periode', $latestPeriode)->get();
        $subkriterias = SubKriteria::all();
        $nilais = Nilai::with(['alternatif', 'subkriteria.kriteria'])
            ->whereIn('alternatif_id', $alternatifs->pluck('id'))
            ->get();

        $bobotTerbesar = Kriteria::max('bobot');
        $kriteriaDenganBobotTerbesar = Kriteria::where('bobot', $bobotTerbesar)->first()->id;

        $rankings = Rangking::with('alternatif')
            ->whereIn('alternatif_id', $alternatifs->pluck('id'))
            ->orderBy('nilai', 'desc')
            ->get()
            ->groupBy('nilai')
            ->flatMap(function ($group) use ($nilais, $kriteriaDenganBobotTerbesar) {
                if ($group->count() > 1) {
                    return $group->sortByDesc(function ($ranking) use ($nilais, $kriteriaDenganBobotTerbesar) {
                        $nilaiAlternatif = $nilais->where('alternatif_id', $ranking->alternatif_id)
                            ->first(function ($nilai) use ($kriteriaDenganBobotTerbesar) {
                                return $nilai->subkriteria->kriteria_id === $kriteriaDenganBobotTerbesar;
                            });
                        return $nilaiAlternatif ? $nilaiAlternatif->nilai : 0;
                    });
                }
                return $group;
            })->values();

        return view('penilaian.index', compact('nilais', 'alternatifs', 'subkriterias', 'rankings'));
    }

    public function add()
    {
        $latestPeriode = Alternatif::max('periode');
        $alternatifs = Alternatif::where('periode', $latestPeriode)
            ->whereNotIn('id', function ($query) {
                $query->select('alternatif_id')->from('nilai');
            })->get();
        $kriterias = Kriteria::with('subkriteria')->get();
        return view('penilaian.tambah', compact('alternatifs', 'kriterias'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'alternatif_id' => 'required',
            'nilai' => 'required|array'
        ]);

        $alternatif_id = $request->alternatif_id;
        $nilai_inputs = $request->nilai;

        $nilaiData = [];
        foreach ($nilai_inputs as $kriteria_id => $nilai) {
            $subkriterias = SubKriteria::where('kriteria_id', $kriteria_id)
                ->where('start', '<=', $nilai)
                ->where('end', '>=', $nilai)
                ->get();
            foreach ($subkriterias as $subkriteria) {
                $nilaiData[] = [
                    'alternatif_id' => $alternatif_id,
                    'subkriteria_id' => $subkriteria->id,
                    'kriteria_id' => $kriteria_id,
                    'nilai' => $nilai,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        Nilai::insert($nilaiData);

        $jumlahAlternatifBerbeda = Nilai::distinct('alternatif_id')->count('alternatif_id') > 1;
        if ($jumlahAlternatifBerbeda) {
            $this->CalculateCopras();
        }
        return redirect('/penilaian');
    }
    public function update(Request $request, Nilai $nilai)
    {
        $request->validate([
            'alternatif_id' => 'required',
            'subkriteria_id' => 'required',
            'nilai' => 'required'
        ]);
        $nilai->update([
            'alternatif_id' => $request->alternatif_id,
            'subkriteria_id' => $request->subkriteria_id,
            'nilai' => $request->nilai
        ]);

        $jumlahAlternatifBerbeda = Nilai::distinct('alternatif_id')->count('alternatif_id') > 1;
        if ($jumlahAlternatifBerbeda) {
            $this->CalculateCopras();
        }
        return redirect('/penilaian');
    }

    public function destroy($id)
    {
        Nilai::destroy('alternatif_id', $id);
        $jumlahAlternatifBerbeda = Nilai::distinct('alternatif_id')->count('alternatif_id') > 1;
        if ($jumlahAlternatifBerbeda) {
            $this->CalculateCopras();
        }
        return redirect('/penilaian');
    }
}
