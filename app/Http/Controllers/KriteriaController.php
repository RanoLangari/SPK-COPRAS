<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index() 
    {
        $kriterias = Kriteria::all();
        return view('kriteria.index', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required',
            'bobot' => 'required',
            'tipe' => 'required'
        ]);      
        Kriteria::create([
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot,
            'tipe' => $request->tipe
        ]);
        return redirect('/kriteria');
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama_kriteria' => 'required',
            'bobot' => 'required',
            'tipe' => 'required'
        ]);
        $kriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'bobot' => $request->bobot,
            'tipe' => $request->tipe
        ]);
        return redirect('/kriteria');
    }

    public function destroy($id)
    {
        Kriteria::destroy($id);
        return redirect('/kriteria');
    }
}
