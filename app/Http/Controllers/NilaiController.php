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
        $alternatifs = Alternatif::all();
        $kriterias = Kriteria::all(); // Mengambil semua kriteria dari tabel kriteria

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
                        // Menghitung nilai normalisasi dengan membagi bobot subkriteria dengan jumlah keseluruhan bobot subkriteria dari seluruh alternatif dengan kriteria yang sama
                        $nilaiNormalisasi[] = [
                            'alternatif_id' => $alternatif->id,
                            'kriteria_id' => $kriteria->id,
                            'subkriteria_id' => $subkriteria->id,
                            'bobot' => $subkriteria->bobot,
                            'total' => $totalBobotSubKriteria,
                            'nilai_normalisasi' => $subkriteria->bobot / $totalBobotSubKriteria
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
                    'subkriteria_id' => $nilai['subkriteria_id'],
                    'kriteria_id' => $nilai['kriteria_id'],
                    'nilai_normalisasi' => $nilai['nilai_normalisasi'],
                    "bobot" => $kriteria->bobot,
                    'nilai_bobot_normalisasi' => $nilai['nilai_normalisasi'] * $subkriteria->bobot
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
                        'total_normalisasi' => 0
                    ];
                }
                $totalNilaiMaksBenefit[$nilai['alternatif_id']]['total_normalisasi'] += $nilai['nilai_bobot_normalisasi'];
            } elseif ($kriteria->tipe == 'Cost') {
                if (!isset($totalNilaiMinCost[$nilai['alternatif_id']])) {
                    $totalNilaiMinCost[$nilai['alternatif_id']] = [
                        'alternatif_id' => $nilai['alternatif_id'],
                        'total_normalisasi' => 0
                    ];
                }
                $totalNilaiMinCost[$nilai['alternatif_id']]['total_normalisasi'] += $nilai['nilai_bobot_normalisasi'];

                $sumMinCostAll += $nilai['nilai_bobot_normalisasi'];
            }
        }
        
        $bobotRelatif = [];
        $totalBobotRelatif = 0;
        
        foreach ($totalNilaiMinCost as $key => $value) {
            $bobotRelatif[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'bobot_relatif' => 1/ $value['total_normalisasi'],
            ];
            $totalBobotRelatif += 1/$value['total_normalisasi'];
        }

        $MultipleTotalBobotRelatifAndMinCost = [];
        foreach ($totalNilaiMinCost as $key => $value) {
            $MultipleTotalBobotRelatifAndMinCost[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'total' => $value['total_normalisasi'] * $totalBobotRelatif,
            ];
        }

        $DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost = [];
        foreach ($MultipleTotalBobotRelatifAndMinCost as $key => $value) {
            $DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'total' => $sumMinCostAll / $value['total'],
            ];
        }

        $QMax = max($DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost);

        $UIValue = [];
        foreach ($DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost as $key => $value) {
            $UIValue[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'value' => ($value['total']/$QMax['total']) * 100
            ];
        }
        
        dd( $sumMinCostAll,$totalNilaiMaksBenefit, $totalNilaiMinCost, $bobotRelatif, $totalBobotRelatif, $MultipleTotalBobotRelatifAndMinCost, $DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost, $QMax, $UIValue);

    }

    public function index()
    {
        // $this->CalculateCopras();
        $nilais =  $nilaiWithRelations = Nilai::with(['alternatif', 'subkriteria.kriteria'])->get();
        $alternatifs = Alternatif::all();
        $subkriterias = SubKriteria::all();
        $rankings = Rangking::all();
        return view('penilaian.index', compact('nilais', 'alternatifs', 'subkriterias', 'rankings'));
    }

    public function add()
    {
        $alternatifs = Alternatif::whereNotIn('id', function ($query) {
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

        foreach ($nilai_inputs as $subkriteria_id => $nilai) {
            Nilai::create([
                'alternatif_id' => $alternatif_id,
                'subkriteria_id' => $nilai
            ]);
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
        return redirect('/penilaian');
    }

    public function destroy($id)
    {
        Nilai::destroy($id);
        return redirect('/penilaian');
    }
}
