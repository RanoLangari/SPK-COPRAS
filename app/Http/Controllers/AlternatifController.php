<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    public function index() 
    {
        $alternatifs = Alternatif::all();
        return view('alternatif.index', compact('alternatifs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alternatif' => 'required'
        ]);      
        Alternatif::create([
            'nama_alternatif' => $request->nama_alternatif
        ]);
        return redirect('/alternatif');

    }


    public function update(Request $request, Alternatif $alternatif)
    {
        $request->validate([
            'nama_alternatif' => 'required'
        ]);
        $alternatif->update([
            'nama_alternatif' => $request->nama_alternatif
        ]);
        return redirect('/alternatif');
    }

    public function destroy($id)
    {
        Alternatif::destroy($id);
        return redirect('/alternatif');
    }
}
