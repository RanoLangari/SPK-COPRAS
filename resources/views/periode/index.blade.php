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
                        @foreach ($availablePeriodes as $periode)
                            <option value="{{ $periode }}" {{ request('periode') == $periode ? 'selected' : '' }}>
                                {{ $periode }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- Dropdown untuk Kategori -->
                <div>
                    <label for="kategori" class="block text-gray-700 text-sm font-bold mb-2">Jenis Pinjaman:</label>
                    <select name="kategori" id="kategori"
                        class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none 
                               focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                        <option value=""> Semua Pinjaman</option>
                        <option value="Pinjaman Umum" {{ request('kategori') == 'Pinjaman Umum' ? 'selected' : '' }}>
                            Pinjaman Umum</option>
                        <option value="Pinjaman Produktif"
                            {{ request('kategori') == 'Pinjaman Produktif' ? 'selected' : '' }}>Pinjaman Produktif
                        </option>
                        <option value="Pinjaman Konsumtif"
                            {{ request('kategori') == 'Pinjaman Konsumtif' ? 'selected' : '' }}>Pinjaman Konsumtif
                        </option>
                        <option value="Pinjaman Lunak" {{ request('kategori') == 'Pinjaman Lunak' ? 'selected' : '' }}>
                            Pinjaman Lunak</option>
                    </select>
                </div>

                <!-- Tombol Cari -->
                <button type="submit"
                    class="self-end px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                    Cari
                </button>
            </form>
        </div>

        <!-- Tampilkan judul dan tabel hanya jika pencarian dilakukan -->
        @if (isset($alternatifs) && $alternatifs->isNotEmpty())

            <!-- Tombol Cetak -->
            <button onclick="printTable('{{ request('periode') }}', '{{ request('kategori') }}')"
                class="mb-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200 ease-in-out">
                Cetak
            </button>

            <!-- Tabel hasil pencarian -->
            <div
                class="bg-white shadow-lg rounded-lg overflow-hidden my-6 transition duration-500 ease-in-out transform hover:scale-105">
                <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">
                    Rekapan Pinjaman Koperasi pada tahun {{ request('periode') }}
                </h2>
                <table class="min-w-full bg-white" id="data-table">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Rangking</th>
                            <th class="py-3 px-6 text-left">Nama Alternatif</th>
                            <th class="py-3 px-6 text-left">Jenis Pinjaman</th>
                            <th class="py-3 px-6 text-left">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @php
                            // Urutkan alternatif berdasarkan nilai dari yang terbesar ke terkecil
                            $sortedAlternatifs = $alternatifs->sortByDesc(function ($alternatif) {
                                return optional($alternatif->rangking)->nilai ?? 0;
                            });

                            // Tambahkan nomor urut mulai dari 1
                            $rank = 1;
                        @endphp

                        @foreach ($sortedAlternatifs as $alternatif)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $rank }}</td>
                                <td class="py-3 px-6 text-left">{{ $alternatif->nama_alternatif }}</td>
                                <td class="py-3 px-6 text-left">{{ $alternatif->kategori }}</td>
                                <td class="py-3 px-6 text-left">
                                    {{ optional($alternatif->rangking)->nilai ?? 'Tidak ada nilai' }}
                                </td>
                            </tr>

                            @php
                                $rank++;
                            @endphp
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
        function printTable(periode, kategori) {
            var originalContents = document.body.innerHTML; // Simpan konten asli
            var printContents = document.getElementById('data-table').outerHTML; // Ambil konten tabel

            // Judul untuk tabel
            var tableTitle =
                '<div style="text-align: center; margin-bottom: 20px;">' +
                '<h2 style="font-size: 24px; margin-bottom: 5px;">KOPERASI XYZ</h2>' +
                '<p style="margin: 0;">Jl. Contoh Alamat No. 123, Kota ABC</p>' +
                '<p style="margin: 0;">Telp: (021) 12345678</p>' +
                '<p style="margin: 0;">Email: info@koperasixyz.com</p>' +
                '<h3 style="font-size: 20px; margin-top: 20px;">Rekapan Pinjaman Koperasi pada tahun ' + periode + '</h3>' +
                '<p style="margin: 0;">Jenis Pinjaman: ' + (kategori ? kategori : 'Semua Pinjaman') + '</p>' +
                '</div>';

            // Hapus semua konten dan masukkan hanya tabel ke dalam body
            document.body.innerHTML = '<html><head><title>Cetak Tabel</title>';
            document.body.innerHTML +=
                '<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid black; padding: 8px; text-align: left;} th {background-color: #f2f2f2;}</style>';
            document.body.innerHTML += '</head><body>';
            document.body.innerHTML += tableTitle; // Tambahkan judul tabel
            document.body.innerHTML += printContents; // Tambahkan konten tabel
            document.body.innerHTML += '</body></html>';

            window.print(); // Cetak jendela saat ini

            document.body.innerHTML = originalContents; // Kembalikan konten asli
        }
    </script>
</x-layout>
