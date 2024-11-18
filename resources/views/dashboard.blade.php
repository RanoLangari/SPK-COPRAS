<x-layout>
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl mt-10">
        <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]"
            aria-hidden="true">
            <div class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]"
            style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        </div>
        <div class="text-center">
            
            <h1 class="text-5xl font-extrabold mb-4 mt-8 text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600">
                Selamat Datang Di Website
            </h1>
            
            <h1 class="text-5xl font-extrabold mb-4 mt-8 text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">
               SPK Copras
            </h1>
            <p class="text-lg text-gray-700 mt-4">
                Sistem Pendukung Keputusan Copras adalah sistem yang membantu pengambilan keputusan dengan metode Copras
            </p>
            {{-- <button class="mt-6 px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                <a href="#">Jelajahi Sekarang</a>
            </button> --}}
        </div>
    
    @php
        $alternatifs = \App\Models\Alternatif::all();
    @endphp
    @php
        $kriterias = \App\Models\Kriteria::all();
    @endphp
    @php
        $subkriterias = \App\Models\SubKriteria::all();
    @endphp

    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
     
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Alternatif</h2>
        <ul class="list-disc list-inside">
            @foreach ($alternatifs as $alternatif)
            <li class="text-gray-700">{{ $alternatif->nama_alternatif }}</li>
            @endforeach
        </ul>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Kriteria</h2>
        <ul class="list-disc list-inside">
            @foreach ($kriterias as $kriteria)
            <li class="text-gray-700">{{ $kriteria->nama_kriteria }}</li>
            @endforeach
        </ul>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Sub Kriteria</h2>
        <ul class="list-disc list-inside">
            @foreach ($subkriterias as $subkriteria)
            <li class="text-gray-700">{{ $subkriteria->nama_subkriteria }}</li>
            @endforeach
        </ul>
    </div>
    </div>
    

</x-layout>
