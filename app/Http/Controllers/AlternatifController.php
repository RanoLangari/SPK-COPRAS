<?php

namespace App\Http\Controllers;

use App\Models\Rangking;
use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index()
    {
        $rangking = Rangking::all();
        $alternatifs = Alternatif::with('rangking')
            ->get()
            ->sortByDesc(function ($alternatif) {
                return optional($alternatif->rangking)->nilai ?? 0;
            });
        $latestPeriode = Alternatif::max('periode');
        $alternatifs = Alternatif::where('periode', $latestPeriode)->get();

        return view('alternatif.index', compact('alternatifs', 'rangking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alternatif' => 'required',
            'periode' => 'required'
        ]);
        Alternatif::create([
            'nama_alternatif' => $request->nama_alternatif,
            'periode' => $request->periode
        ]);
        return redirect('/alternatif');
    }


    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'nama_alternatif' => 'required',
            'periode' => 'required'
        ]);
        $alternatif->update([
            'nama_alternatif' => $request->nama_alternatif,
            'periode' => $request->periode
        ]);
        return redirect('/alternatif');
    }

    public function destroy($id)
    {
        Alternatif::destroy($id);
        return redirect('/alternatif');
    }
}
