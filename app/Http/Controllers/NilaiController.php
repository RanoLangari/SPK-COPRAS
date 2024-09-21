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
        $subkriterias = SubKriteria::all();

        foreach ($alternatifs as $alternatif) {
            foreach ($subkriterias as $subkriteria) {
                $nilai = Nilai::where([
                    'alternatif_id' => $alternatif->id,
                    'subkriteria_id' => $subkriteria->id
                ])->first();
                if ($nilai) {
                    $nilaiNormalisasi[] = [
                        'alternatif_id' => $alternatif->id,
                        'subkriteria_id' => $subkriteria->id,
                        'nilai_normalisasi' => $nilai->nilai / Nilai::where('subkriteria_id', $subkriteria->id)->sum('nilai')
                    ];
                }
            }
        }

        $nilaiBobotNormalisasi = [];
        foreach ($nilaiNormalisasi as $nilai) {
            $subkriteria = SubKriteria::find($nilai['subkriteria_id']);
            if ($subkriteria) {
                $nilaiBobotNormalisasi[] = [
                    'alternatif_id' => $nilai['alternatif_id'],
                    'subkriteria_id' => $nilai['subkriteria_id'],
                    'nilai_normalisasi' => $nilai['nilai_normalisasi'],
                    'nilai_bobot_normalisasi' => $nilai['nilai_normalisasi'] * $subkriteria->bobot
                ];
            }
        }
        dd($nilaiBobotNormalisasi);
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
            'nilai' => 'required'
        ]);
    
        $alternatif_id = $request->alternatif_id;
        $nilai_inputs = $request->nilai;
    
        foreach ($nilai_inputs as $subkriteria_id => $nilai) {
            Nilai::create([
                'alternatif_id' => $alternatif_id,
                'subkriteria_id' => $subkriteria_id,
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
