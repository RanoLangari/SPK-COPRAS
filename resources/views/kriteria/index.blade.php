<x-layout>
    <!-- Container Utama -->
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Kriteria</h2>
            @if (Auth::user()->role == 'operator')
            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                Tambah Kriteria
            </button>
            @endif
        </div>

        <!-- Tabel Kriteria -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="kriteriaTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama Kriteria</th>
                        <th scope="col" class="px-6 py-3">Bobot</th>
                        <th scope="col" class="px-6 py-3">Tipe</th>
                        @if (Auth::user()->role == 'operator')
                        <th scope="col" class="px-6 py-3">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kriterias as $kriteria)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $kriteria->nama_kriteria }}</td>
                        <td class="px-6 py-4">{{ $kriteria->bobot }}</td>
                        <td class="px-6 py-4">{{ $kriteria->tipe }}</td>
                        @if (Auth::user()->role == 'operator')
                        <td class="px-8 py-6 flex space-x-4">
                            <!-- Tombol Edit -->
                            <button type="button" class="text-blue-600 hover:text-blue-900"
                                data-modal-target="edit-modal-{{ $kriteria->id }}"
                                data-modal-toggle="edit-modal-{{ $kriteria->id }}">
                                Edit
                            </button>

                            <!-- Tombol Delete -->
                            <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST"
                                class="inline" id="delete-form-{{ $kriteria->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-900"
                                    onclick="confirmDelete({{ $kriteria->id }})">
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
                                            document.getElementById('delete-form-' + id).submit();
                                        }
                                    })
                                }
                            </script>
                            <!-- Modal Edit -->
                            <div id="edit-modal-{{ $kriteria->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Edit Kriteria
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-toggle="edit-modal-{{ $kriteria->id }}">
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
                                        <form class="p-4 md:p-5"
                                            action="{{ route('kriteria.update', $kriteria->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                <div class="col-span-2">
                                                    <label for="nama_kriteria"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                                        Kriteria</label>
                                                    <input type="text" name="nama_kriteria" id="nama_kriteria"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                                        value="{{ $kriteria->nama_kriteria }}" required>
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="bobot" class="block mb-2 text-sm font-medium text-gray-900">Bobot</label>
                                                    <input type="number" step=".01" name="bobot" id="bobot"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                                        value="{{ $kriteria->bobot }}" required>
                                                </div>
                                                <div class="col-span-2">
                                                    <label for="tipe" class="block mb-2 text-sm font-medium text-gray-900">Tipe</label>
                                                    <select name="tipe" id="tipe"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                                        <option value="Cost" {{ $kriteria->tipe == 'Cost' ? 'selected' : '' }}>Cost</option>
                                                        <option value="Benefit" {{ $kriteria->tipe == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Update Kriteria
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah Kriteria -->
        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Tambah Kriteria
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form class="p-4" action="{{ route('kriteria.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_kriteria" class="block text-sm font-medium text-gray-900 dark:text-white">
                                Nama Kriteria
                            </label>
                            <input type="text" name="nama_kriteria" id="nama_kriteria"
                                class="block w-full mt-1 p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="bobot" class="block text-sm font-medium text-gray-900 dark:text-white">
                                Bobot
                            </label>
                            <input type="number" step=".01" name="bobot" id="bobot"
                                class="block w-full mt-1 p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="tipe" class="block text-sm font-medium text-gray-900 dark:text-white">
                                Tipe
                            </label>
                            <select name="tipe" id="tipe"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Cost">Cost</option>
                                <option value="Benefit">Benefit</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                            Tambah Kriteria
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- DataTables Script -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#kriteriaTable').DataTable({
                    paging: true,
                    searching: true,
                    info: true,
                    autoWidth: false,
                    responsive: true
                });
            });
        </script>
    </div>
</x-layout>
