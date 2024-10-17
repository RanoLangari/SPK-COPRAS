<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
  
    // Method untuk menampilkan form pencarian periode
    public function index(Request $request)
    {
        // Ambil semua periode unik untuk dropdown
        $availablePeriodes = Alternatif::pluck('periode')->unique()->map(function ($periode) {
            return $this->formatPeriode($periode);
        });

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
        $formattedPeriode = $request->input('periode');

        // Ubah kembali periode dari format "Tahun, Bulan, Minggu ke-" menjadi format aslinya "YYYY-WW"
        $periode = $this->reverseFormatPeriode($formattedPeriode);

        // Ambil data alternatif berdasarkan periode yang dipilih
        $alternatifs = Alternatif::where('periode', $periode)->get();

        // Parsing periode dari format YYYY-WW menjadi Tahun, Bulan, dan Minggu sesuai kalender
        [$year, $weekNumber] = explode('-W', $periode); // Misal 2024-W42
        $weekNumber = (int) $weekNumber;

        // Menghitung bulan berdasarkan minggu ke berapa
        $firstDayOfYear = new \DateTime($year . '-01-01');
        $firstDayOfYear->modify('+' . ($weekNumber - 1) . ' weeks');
        $month = $firstDayOfYear->format('F'); // Format nama bulan

        // Kirimkan hasil pencarian dan periode yang dipilih ke view
        return view('periode.index', [
            'availablePeriodes' => Alternatif::pluck('periode')->unique()->map(function ($periode) {
                return $this->formatPeriode($periode);
            }),
            'alternatifs' => $alternatifs, // Data alternatif berdasarkan periode
            'searchedPeriode' => $formattedPeriode, // Periode yang dicari, dalam format yang sudah diubah
            'year' => $year, // Tahun
            'month' => $month, // Nama bulan
            'week' => $weekNumber // Minggu keberapa
        ]);
    }

    private function formatPeriode($periode)
    {
        // Parsing periode dari format YYYY-WW menjadi Tahun, Bulan, dan Minggu sesuai kalender
        [$year, $weekNumber] = explode('-W', $periode); // Misal 2024-W42
        $weekNumber = (int) $weekNumber;

        // Menghitung bulan berdasarkan minggu ke berapa
        $firstDayOfYear = new \DateTime($year . '-01-01');
        $firstDayOfYear->modify('+' . ($weekNumber - 1) . ' weeks');
        $month = $firstDayOfYear->format('F'); // Format nama bulan

        // Menghitung jumlah minggu dalam bulan tersebut
        $firstDayOfMonth = new \DateTime($year . '-' . $firstDayOfYear->format('m') . '-01');
        $lastDayOfMonth = new \DateTime($firstDayOfMonth->format('Y-m-t'));
        $interval = new \DateInterval('P1W');
        $period = new \DatePeriod($firstDayOfMonth, $interval, $lastDayOfMonth);

        $weekOfMonth = 1;
        foreach ($period as $dt) {
            if ($dt->format('W') == $weekNumber) {
                break;
            }
            $weekOfMonth++;
        }

        return $year . ', ' . $month . ', Minggu ke-' . $weekOfMonth;
    }

    private function reverseFormatPeriode($formattedPeriode)
    {
        // Ubah kembali periode dari format "Tahun, Bulan, Minggu ke-" menjadi format aslinya "YYYY-WW"
        [$year, $month, $weekOfMonth] = explode(', ', $formattedPeriode);
        $weekOfMonth = (int) str_replace('Minggu ke-', '', $weekOfMonth);

        // Menghitung minggu ke berapa dalam tahun tersebut
        $firstDayOfMonth = new \DateTime($year . '-' . date('m', strtotime($month)) . '-01');
        $firstDayOfMonth->modify('+' . ($weekOfMonth - 1) . ' weeks');
        $weekNumber = $firstDayOfMonth->format('W');

        return $year . '-W' . $weekNumber;
    }
}
