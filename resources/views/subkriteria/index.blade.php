<x-layout>
    <!-- Container Utama -->
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Daftar SubKriteria</h2>
            @if (Auth::user()->role == 'operator')
            <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                Tambah SubKriteria
            </button>
            @endif
        </div>

        <!-- Tabel SubKriteria -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="subKriteriaTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama SubKriteria</th>
                        <th scope="col" class="px-6 py-3">Bobot</th>
                        <th scope="col" class="px-6 py-3">Kriteria</th>
                        <th scope="col" class="px-6 py-3">Created At</th>
                        <th scope="col" class="px-6 py-3">Updated At</th>
                        @if (Auth::user()->role == 'operator')
                        <th scope="col" class="px-6 py-3">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subkriterias as $subkriteria)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $subkriteria->nama_subkriteria }}</td>
                        <td class="px-6 py-4">{{ $subkriteria->bobot }}</td>
                        <td class="px-6 py-4">{{ $subkriteria->kriteria->nama_kriteria }}</td>
                        <td class="px-6 py-4">{{ $subkriteria->created_at }}</td>
                        <td class="px-6 py-4">{{ $subkriteria->updated_at }}</td>
                        @if (Auth::user()->role == 'operator')
                        <td class="px-8 py-6 flex space-x-4">
                            <!-- Tombol Edit -->
                            <button type="button" class="text-blue-600 hover:text-blue-900"
                                data-modal-target="edit-modal-{{ $subkriteria->id }}"
                                data-modal-toggle="edit-modal-{{ $subkriteria->id }}">
                                Edit
                            </button>

                            <!-- Tombol Delete -->
                            <form action="{{ route('subkriteria.destroy', $subkriteria->id) }}" method="POST"
                                class="inline" id="delete-form-{{ $subkriteria->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-900"
                                    onclick="confirmDelete({{ $subkriteria->id }})">
                                    Delete
                                </button>
                            </form>

                            <!-- Modal Edit -->
                            <div id="edit-modal-{{ $subkriteria->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Edit SubKriteria
                                            </h3>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-toggle="edit-modal-{{ $subkriteria->id }}">
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
                                            action="{{ route('subkriteria.update', $subkriteria->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                <div class="col-span-2">
                                                    <label for="nama_subkriteria"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                                        SubKriteria</label>
                                                    <input type="text" name="nama_subkriteria" id="nama_subkriteria"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        value="{{ $subkriteria->nama_subkriteria }}" required="">
                                                </div>
                                                <div>
                                                    <label for="bobot" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bobot</label>
                                                    <input type="number" id="bobot" name="bobot" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $subkriteria->bobot }}" required>
                                                </div>
                                                <div>
                                                    <label for="kriteria_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kriteria</label>
                                                    <select id="kriteria_id" name="kriteria_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                        @foreach ($kriterias as $kriteria)
                                                            <option value="{{ $kriteria->id }}" {{ $kriteria->id == $subkriteria->kriteria_id ? 'selected' : '' }}>{{ $kriteria->nama_kriteria }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                Update SubKriteria
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Script untuk konfirmasi delete -->
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
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah SubKriteria -->
        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal Content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Tambah SubKriteria
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
                    <form class="p-4" action="{{ route('subkriteria.store') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="nama_subkriteria" class="block text-sm font-medium text-gray-900 dark:text-white">Nama SubKriteria</label>
                                <input type="text" name="nama_subkriteria" id="nama_subkriteria"
                                    class="block w-full mt-1 p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                    required>
                            </div>
                            <div>
                                <label for="bobot" class="block text-sm font-medium text-gray-900 dark:text-white">Bobot</label>
                                <input type="number" id="bobot" name="bobot" class="block w-full mt-1 p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white" required>
                            </div>
                            <div>
                                <label for="kriteria_id" class="block text-sm font-medium text-gray-900 dark:text-white">Kriteria</label>
                                <select id="kriteria_id" name="kriteria_id" class="block w-full mt-1 p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white" required>
                                    @foreach ($kriterias as $kriteria)
                                        <option value="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                            Tambah SubKriteria
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
                $('#subKriteriaTable').DataTable({
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
