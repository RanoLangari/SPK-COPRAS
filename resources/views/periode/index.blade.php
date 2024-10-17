<x-layout>
<div class="container mx-auto mt-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold text-gray-700">Pencarian Periode</h1>
        <form action="{{ route('periode.search') }}" method="GET" class="flex space-x-4">
            <!-- Dropdown untuk Periode -->
            <div>
                <label for="periode" class="block text-gray-700 text-sm font-bold mb-2">Periode:</label>
                <select name="periode" id="periode" 
                        class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none 
                               focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out" 
                        required>
                    <option value="">-- Pilih Periode --</option>
                    @foreach($availablePeriodes as $periode)
                        <option value="{{ $periode }}" {{ request('periode') == $periode ? 'selected' : '' }}>
                            {{ $periode }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Cari -->
            <button type="submit" class="self-end px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                Cari
            </button>
        </form>
    </div>

    <!-- Tampilkan judul dan tabel hanya jika pencarian dilakukan -->
    @if(isset($alternatifs) && $alternatifs->isNotEmpty())
       
        <!-- Tombol Cetak -->
        <button onclick="printTable()" class="mb-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 ease-in-out">
            Cetak
        </button>

        <!-- Tabel hasil pencarian -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden my-6 transition duration-500 ease-in-out transform hover:scale-105">
            <table class="min-w-full bg-white" id="data-table">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nama Alternatif</th>
                        <th class="py-3 px-6 text-left">Periode</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($alternatifs as $alternatif)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ $alternatif->nama_alternatif }}</td>
                            <td class="py-3 px-6 text-left">{{ $alternatif->periode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif(isset($searchedPeriode))
        <p class="text-gray-600 mt-4">Tidak ada data untuk periode yang dicari.</p>
    @else
        <p class="text-gray-500 text-lg mt-4">Silakan pilih periode untuk melakukan pencarian.</p>
    @endif
    
</div>

<!-- Script untuk cetak -->
<script>
    function printTable() {
        var originalContents = document.body.innerHTML; // Simpan konten asli
        var printContents = document.getElementById('data-table').outerHTML; // Ambil konten tabel

        // Judul untuk tabel
        var tableTitle = '<h2 style="text-align: center; font-size: 24px; margin-bottom: 20px;">Rekapan Pinjaman Koperasi pada tahun {{ $periode }} </h2>';
        
        // Hapus semua konten dan masukkan hanya tabel ke dalam body
        document.body.innerHTML = '<html><head><title>Cetak Tabel</title>';
        document.body.innerHTML += '<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid black; padding: 8px; text-align: left;} th {background-color: #f2f2f2;}</style>';
        document.body.innerHTML += '</head><body>';
        document.body.innerHTML += tableTitle; // Tambahkan judul tabel
        document.body.innerHTML += printContents; // Tambahkan konten tabel
        document.body.innerHTML += '</body></html>';

        window.print(); // Cetak jendela saat ini

        document.body.innerHTML = originalContents; // Kembalikan konten asli
    }
</script>

</x-layout>
