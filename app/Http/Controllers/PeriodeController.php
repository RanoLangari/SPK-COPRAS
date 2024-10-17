<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    // Method untuk menampilkan form pencarian periode
    public function index()
    {
        // Ambil semua periode unik untuk dropdown
        $availablePeriodes = Alternatif::pluck('periode')->unique();

        // Kirimkan availablePeriodes ke view, tanpa tabel hasil (tidak ada pencarian dilakukan)
        return view('periode.index', compact('availablePeriodes'));
    }

    // Method untuk menangani pencarian berdasarkan periode
    public function search(Request $request)
    {
        // Validasi input periode
        $request->validate([
            'periode' => 'required|string',
        ]);

        // Ambil input periode dari form
        $periode = $request->input('periode');

        // Ambil data alternatif berdasarkan periode yang dipilih
        $alternatifs = Alternatif::where('periode', $periode)->get();

        // Kirimkan hasil pencarian dan periode yang dipilih ke view
        return view('periode.index', [
            'availablePeriodes' => Alternatif::pluck('periode')->unique(), // Dropdown periode
            'alternatifs' => $alternatifs, // Data alternatif berdasarkan periode
            'searchedPeriode' => $periode // Periode yang dicari, untuk keperluan pencetakan judul
        ]);
    }
}
