<x-layout>
    <div class="container mx-auto mt-10">
        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Profil</h1>

            <form id="profile-form" action="{{ route('profile.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama:</label>
                    <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
                    <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password (Biarkan kosong jika tidak ingin mengubah):</label>
                    <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Konfirmasi Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:border-blue-500">
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Cek apakah session memiliki pesan sukses
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = "{{ route('login') }}";
        });
        @endif

        // Event Listener untuk form
        const form = document.getElementById('profile-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah pengiriman form secara langsung

            const password = document.getElementById('password').value;
            if (password) {
                Swal.fire({
                    title: 'Anda yakin ingin mengubah password?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, ubah password',
                    cancelButtonText: 'Tidak, batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Jika pengguna mengonfirmasi, kirim form
                       
                    }
                });
            } else {
                form.submit(); // Jika tidak ada password yang diisi, kirim form langsung
            }
        });
    </script>
</x-layout>