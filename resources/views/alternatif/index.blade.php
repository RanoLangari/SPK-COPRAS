<x-layout>
    <!-- Container Utama  max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg-->
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8">


        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Alternatif</h2>
            @if (Auth::user()->role == 'operator')
                <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                    Tambah Alternatif
                </button>
            @endif
        </div>

        <!-- Tabel Alternatif -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="alternatifTable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama Alternatif</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Periode</th>
                        <th scope="col" class="px-6 py-3">Created At</th>
                        <th scope="col" class="px-6 py-3">Updated At</th>
                        @if (Auth::user()->role == 'operator')
                            <th scope="col" class="px-6 py-3">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alternatifs as $alternatif)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $alternatif->nama_alternatif }}</td>
                            <td class="px-6 py-4">{{ $alternatif->kategori }}</td>
                            <td class="px-6 py-4">{{ $alternatif->periode }}</td>
                            <td class="px-6 py-4">{{ $alternatif->created_at }}</td>
                            <td class="px-6 py-4">{{ $alternatif->updated_at }}</td>
                            @if (Auth::user()->role == 'operator')
                                <td class="px-8 py-6 flex space-x-4">
                                    <!-- Tombol Edit -->
                                    <button type="button" class="text-blue-600 hover:text-blue-900"
                                        data-modal-target="edit-modal-{{ $alternatif->id }}"
                                        data-modal-toggle="edit-modal-{{ $alternatif->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('alternatif.destroy', $alternatif->id) }}" method="POST"
                                        class="inline" id="delete-form-{{ $alternatif->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="text-red-600 hover:text-red-900"
                                            onclick="confirmDelete({{ $alternatif->id }})">
                                            Delete
                                        </button>
                                    </form>

                                    <!-- Modal Edit -->
                                    <div id="edit-modal-{{ $alternatif->id }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        Edit Alternatif
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-toggle="edit-modal-{{ $alternatif->id }}">
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
                                                    action="{{ route('alternatif.update', $alternatif->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid gap-4 mb-4 grid-cols-2">
                                                        <div class="col-span-2">
                                                            <label for="nama_alternatif"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                                                Alternatif</label>
                                                            <input type="text" name="nama_alternatif"
                                                                id="nama_alternatif"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                                value="{{ $alternatif->nama_alternatif }}"
                                                                required="">
                                                            <label for="periode"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Periode</label>
                                                            <input type="week" name="periode" id="periode"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                                value="{{ $alternatif->periode }}" required="">
                                                            <label for="kategori"
                                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                                                            <select name="kategori" id="kategori"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                                required>
                                                                <option value="Pinjaman Umum" {{ $alternatif->kategori == 'Pinjaman Umum' ? 'selected' : '' }}>Pinjaman Umum</option>
                                                                <option value="Pinjaman Produktif" {{ $alternatif->kategori == 'Pinjaman Produktif' ? 'selected' : '' }}>Pinjaman Produktif</option>
                                                                <option value="Pinjaman Konsumtif" {{ $alternatif->kategori == 'Pinjaman Konsumtif' ? 'selected' : '' }}>Pinjaman Konsumtif</option>
                                                                <option value="Pinjaman Lunak" {{ $alternatif->kategori == 'Pinjaman Lunak' ? 'selected' : '' }}>Pinjaman Lunak</option>
                                                            </select>
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
                                                        Update Alternatif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.querySelectorAll('#edit-modal-{{ $alternatif->id }} form').forEach(form => {
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
                                                                'X-CSRF-TOKEN': document.querySelector(
                                                                    'input[name="_token"]').value
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
                                                                    'X-CSRF-TOKEN': document.querySelector(
                                                                        'input[name="_token"]').value
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
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah Alternatif -->
        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal Content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Tambah Alternatif
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form class="p-4" action="{{ route('alternatif.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama_alternatif" class="block text-sm font-medium text-gray-900 dark:text-white">
                                Nama Alternatif
                            </label>
                            <input type="text" name="nama_alternatif" id="nama_alternatif"
                                class="block w-full mt-1 p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="periode" class="block text-sm font-medium text-gray-900 dark:text-white">
                                Periode
                            </label>
                            <input type="week" name="periode" id="periode"
                                class="block w-full mt-1 p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="kategori" class="block text-sm font-medium text-gray-900 dark:text-white">
                                Jenis Pinjaman
                            </label>
                            <select name="kategori" id="kategori"
                                class="block w-full mt-1 p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                                <option value="Pinjaman Umum">Pinjaman Umum</option>
                                <option value="Pinjaman Produktif">Pinjaman Produktif</option>
                                <option value="Pinjaman Konsumtif">Pinjaman Konsumtif</option>
                                <option value="Pinjaman Lunak">Pinjaman Lunak</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                            Tambah Alternatif
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            document.querySelector('#crud-modal form').addEventListener('submit', function(event) {
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
                                text: 'Data berhasil ditambahkan.',
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
        </script>

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
                    pageLength: 25,
                    autoWidth: false,
                    responsive: true
                });
            });
        </script>
    </div>
</x-layout>
