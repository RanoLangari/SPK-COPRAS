<?php

namespace App\Http\Controllers;

use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;


class SubKriteriaController extends Controller
{
   public function index()
   {

         $subkriterias = SubKriteria::with('kriteria')->get();
         $kriterias = Kriteria::all();
         return view('subkriteria.index', compact('subkriterias', 'kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_subkriteria' => 'required',
            'bobot' => 'required',
            'kriteria_id' => 'required'
        ]);
        SubKriteria::create([
            'nama_subkriteria' => $request->nama_subkriteria,
            'bobot' => $request->bobot,
            'kriteria_id' => $request->kriteria_id
        ]);
        return redirect('/subkriteria');
    }

    public function update(Request $request, SubKriteria $subkriteria)
    {
        $request->validate([
            'nama_subkriteria' => 'required',
            'bobot' => 'required',
            'kriteria_id' => 'required'
        ]);
        $subkriteria->update([
            'nama_subkriteria' => $request->nama_subkriteria,
            'bobot' => $request->bobot,
            'kriteria_id' => $request->kriteria_id
        ]);
        return redirect('/subkriteria');
    }

    public function destroy($id)
    {
        SubKriteria::destroy($id);
        return redirect('/subkriteria');
    }
}
