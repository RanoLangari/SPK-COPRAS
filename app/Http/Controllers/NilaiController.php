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
                    'nama_alternatif' => $nilai['nama_alternatif'],
                    'subkriteria_id' => $nilai['subkriteria_id'],
                    'kriteria_id' => $nilai['kriteria_id'],
                    'nilai_normalisasi' => $nilai['nilai_normalisasi'],
                    "bobot" => $kriteria->bobot,
                    'nilai_bobot_normalisasi' => $nilai['nilai_normalisasi'] * $kriteria->bobot
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
                $totalNilaiMaksBenefit[$nilai['alternatif_id']]['total_normalisasi'] += $nilai['nilai_bobot_normalisasi'];
            } elseif ($kriteria->tipe == 'Cost') {
                if (!isset($totalNilaiMinCost[$nilai['alternatif_id']])) {
                    $totalNilaiMinCost[$nilai['alternatif_id']] = [
                        'alternatif_id' => $nilai['alternatif_id'],
                        'nama_alternatif' => $nilai['nama_alternatif'],
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
                'nama_alternatif' => $value['nama_alternatif'],
                'bobot_relatif' => 1 / $value['total_normalisasi'],
            ];
            $totalBobotRelatif += 1 / $value['total_normalisasi'];
        }

        $MultipleTotalBobotRelatifAndMinCost = [];
        foreach ($totalNilaiMinCost as $key => $value) {
            $MultipleTotalBobotRelatifAndMinCost[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'nama_alternatif' => $value['nama_alternatif'],
                'total' => $value['total_normalisasi'] * $totalBobotRelatif,
            ];
        }

        $DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost = [];
        foreach ($MultipleTotalBobotRelatifAndMinCost as $key => $value) {
            $DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost[$key] = [
                'alternatif_id' => $value['alternatif_id'],
                'nama_alternatif' => $value['nama_alternatif'],
                'total' => $sumMinCostAll / $value['total'],
            ];
        }

        $totalQmax = [];
        foreach ($DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost as $key => $value) {
            if (isset($totalNilaiMaksBenefit[$value['alternatif_id']])) {
                $totalQmax[$key] = [
                    'alternatif_id' => $value['alternatif_id'],
                    'nama_alternatif' => $value['nama_alternatif'],
                    'maksbenefit' => $totalNilaiMaksBenefit[$value['alternatif_id']]['total_normalisasi'],
                    'total' => $value['total'] + $totalNilaiMaksBenefit[$value['alternatif_id']]['total_normalisasi'],
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

        // dd($nilaiNormalisasi, $nilaiBobotNormalisasi, $sumMinCostAll, $totalNilaiMaksBenefit, $totalNilaiMinCost, $bobotRelatif, $totalBobotRelatif, $MultipleTotalBobotRelatifAndMinCost, $DistributionSumMinCostAllWithMultipleTotalBobotRelatifAndMinCost,$totalQmax, $QMax, $UIValue);

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
        $rankings = Rangking::whereIn('alternatif_id', $alternatifs->pluck('id'))
                            ->orderBy('nilai', 'desc')
                            ->get();
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

        foreach ($nilai_inputs as $subkriteria_id => $nilai) {
            Nilai::create([
                'alternatif_id' => $alternatif_id,
                'subkriteria_id' => $nilai
            ]);
        }
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
        Nilai::destroy($id);
        $jumlahAlternatifBerbeda = Nilai::distinct('alternatif_id')->count('alternatif_id') > 1;
        if ($jumlahAlternatifBerbeda) {
            $this->CalculateCopras();
        }
        return redirect('/penilaian');
    }
}
