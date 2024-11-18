<x-layout>
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Penilaian</h2>
            @if (Auth::user()->role == 'operator')
            <button type="button" onclick="window.location.href='{{ route('penilaian.add') }}'"
                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                Tambah Penilaian
            </button>
            @endif
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="alternatifTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
             <tr>
                    <th scope="col" class="px-6 py-3">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Alternatif
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kriteria
                    </th>
                    <th scope="col" class="px-6 py-3">
                        SubKriteria
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nilai
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Dibuat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Diperbarui
                    </th>
                    @if (Auth::user()->role == 'operator')
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($nilais as $index => $nilai)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $index + 1 }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $nilai->alternatif->nama_alternatif }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $nilai->subkriteria->kriteria->nama_kriteria }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $nilai->subkriteria->nama_subkriteria }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $nilai->subkriteria->bobot }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $nilai->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $nilai->updated_at->format('d/m/Y H:i') }}
                    </td>
                    @if (Auth::user()->role == 'operator')
                    <td class="px-8 py-6">
                        <!-- Tombol Edit -->
                        <button type="button" class="text-blue-600 hover:text-blue-900"
                            data-modal-target="edit-modal-{{ $nilai->id }}"
                            data-modal-toggle="edit-modal-{{ $nilai->id }}">
                            Edit
                        </button>

                        <!-- Tombol Delete -->
                        <form action="{{ route('penilaian.destroy', $nilai->id) }}" method="POST" class="inline"
                            id="delete-form-{{ $nilai->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="text-red-600 hover:text-red-900"
                                onclick="confirmDelete({{ $nilai->id }})">
                                Delete
                            </button>
                        </form>

                        <script>
                            function confirmDelete(id) {
                                Swal.fire({
                                    title: 'Apakah Anda yakin?',
                                    text: "Anda tidak akan dapat mengembalikan ini!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        var form = document.getElementById('delete-form-' + id);
                                        var formData = new FormData(form);
                                        Swal.fire({
                                            title: 'Sedang diproses...',
                                            text: 'Mohon tunggu sebentar.',
                                            icon: 'info',
                                            allowOutsideClick: false,
                                            showConfirmButton: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                                fetch(form.action, {
                                                    method: 'POST',
                                                    body: formData,
                                                    headers: {
                                                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                                    }
                                                }).then(response => {
                                                    if (response.ok) {
                                                        return response.json().catch(() => ({}));
                                                    }
                                                    throw new Error('Network response was not ok.');
                                                }).then(data => {
                                                    Swal.fire({
                                                        title: 'Berhasil!',
                                                        text: 'Data berhasil dihapus.',
                                                        icon: 'success',
                                                        confirmButtonText: 'OK'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            location.reload();
                                                        }
                                                    });
                                                }).catch(error => {
                                                    Swal.fire({
                                                        title: 'Error!',
                                                        text: 'Terjadi kesalahan, silakan coba lagi.',
                                                        icon: 'error',
                                                        confirmButtonText: 'OK'
                                                    });
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        </script>
                        <!-- Loading Spinner -->

                        <!-- Modal Edit -->
                        <div id="edit-modal-{{ $nilai->id }}" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Edit Penilaian
                                        </h3>
                                        <button type="button"
                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-toggle="edit-modal-{{ $nilai->id }}">
                                            <svg class="w-3 h-3" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <form class="p-4 md:p-5" action="{{ route('penilaian.update', $nilai->id) }}"
                                        method="POST" onsubmit="return handleUpdate(event, {{ $nilai->id }})">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid gap-4 mb-4 grid-cols-2">
                                            <div class="col-span-2">
                                                <label for="alternatif_id"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alternatif</label>
                                                <select name="alternatif_id" id="alternatif_id"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    required="">
                                                    <option value="" disabled selected>Pilih Alternatif
                                                    </option>
                                                    @foreach ($alternatifs as $alternatif)
                                                    <option value="{{ $alternatif->id }}"
                                                        {{ $nilai->alternatif_id == $alternatif->id ? 'selected' : '' }}>
                                                        {{ $alternatif->nama_alternatif }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-span-2">
                                                <label for="subkriteria_id"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SubKriteria</label>
                                                <select name="subkriteria_id" id="subkriteria_id"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    required="">
                                                    <option value="" disabled selected>Pilih SubKriteria
                                                    </option>
                                                    @foreach ($subkriterias as $subkriteria)
                                                    <option value="{{ $subkriteria->id }}"
                                                        {{ $nilai->subkriteria_id == $subkriteria->id ? 'selected' : '' }}>
                                                        {{ $subkriteria->nama_subkriteria }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-span-2">
                                                <label for="nilai"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai</label>
                                                <input type="number" name="nilai" id="nilai"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                    value="{{ $nilai->nilai }}" required="">
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Update Penilaian
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.querySelectorAll('#edit-modal-{{ $nilai->id }} form').forEach(form => {
                                form.addEventListener('submit', function(event) {
                                    event.preventDefault();
                                    var form = this;
                                    Swal.fire({
                                        title: 'Sedang diproses...',
                                        text: 'Mohon tunggu sebentar.',
                                        icon: 'info',
                                        allowOutsideClick: false,
                                        showConfirmButton: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            var formData = new FormData(form);
                                            fetch(form.action, {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                                }
                                            }).then(response => {
                                                if (response.ok) {
                                                    return response.json().catch(() => ({}));
                                                }
                                                throw new Error('Network response was not ok.');
                                            }).then(data => {
                                                Swal.fire({
                                                    title: 'Berhasil!',
                                                    text: 'Data berhasil diperbarui.',
                                                    icon: 'success',
                                                    confirmButtonText: 'OK'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        location.reload();
                                                    }
                                                });
                                            }).catch(error => {
                                                Swal.fire({
                                                    title: 'Error!',
                                                    text: 'Terjadi kesalahan, silakan coba lagi.',
                                                    icon: 'error',
                                                    confirmButtonText: 'OK'
                                                });
                                            });
                                        }
                                    });
                                });
                            });
                        </script>
                    </td>

                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <!-- Tabel Rangking -->
        <div class="mt-16">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tabel Rangking</h2>
            <table id="rangkingTable"
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Alternatif
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Nilai
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rankings->sortByDesc('nilai') as $ranking)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $ranking->alternatif->nama_alternatif }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($ranking->nilai, 2, '.', '') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

     <!-- DataTables Script -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        
        <script>
            $(document).ready(function() {
                $('#alternatifTable').DataTable({
                    paging: true,
                    searching: true,
                    info: true,
                    pageLength: 50,
                    autoWidth: false,
                    responsive: true,
                    columnDefs: [
                        {
                            targets: [1], // Kolom kedua (index 1) adalah kolom nama alternatif
                            searchable: true
                        },
                        {
                            targets: '_all',
                            searchable: false
                        }
                    ]
                });
            });
        </script>
</x-layout>