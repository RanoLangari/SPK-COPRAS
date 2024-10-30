<x-layout>
<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-8">
    <form  method="POST" action="{{ route('penilaian.store') }}">
        @csrf
        <div class="mb-4">
            <h2 class="block text-lg font-medium text-blue-700 mb-4">Alternatif</h2>
            <label for="alternatif_id" class="block text-sm font-medium text-gray-700">Alternatif</label>
            <select id="alternatif_id" name="alternatif_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <option value="" selected disabled>Pilih Alternatif</option>
                @foreach ($alternatifs as $alternatif)
                    <option value="{{ $alternatif->id }}">{{ $alternatif->nama_alternatif }}</option>
                @endforeach
            </select>
        </div>
       <div class="mt-4">
        <h2 class="block text-lg font-medium text-blue-700 mb-4">Kriteria & Subkriteria</h2>
        @foreach ($kriterias as $kriteria)
        <div class="mb-4">
            <label for="nilai" class="block text-sm font-medium text-gray-700">Kriteria - {{ $kriteria->nama_kriteria }}</label>
            <input type="number" step="0.01" id="nilai[]" name="nilai[{{ $kriteria->id }}]" class="mt-4 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" placeholder="Masukkan Nilai">
        </div>
    @endforeach
       </div>
    <div class="flex justify-end">
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Simpan
        </button>
    </div>
    </form>
</div>
</x-layout>