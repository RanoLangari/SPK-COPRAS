<!DOCTYPE html>
<html lang="en" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        @vite(['resources/css/app.css','resources/js/app.js'])
        <title>Login</title>
        <style>
            body {
                background-image: url('{{ asset('img/kantor.jpeg') }}');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            .login-form {
                background-color: rgba(255, 255, 255, 0.8);
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            #loading {
                display: none;
                color: blue;
                font-size: 14px;
                text-align: center;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body class="h-full">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                @if (session()->has('error_message'))
                    <div class="alert alert-danger text-red-700 bg-red-100 border border-red-400 px-4 py-3 rounded relative mb-8"
                        role="alert">
                        {{ session()->get('error_message') }}
                    </div>
                @endif
            </div>

            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm login-form">
                <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Masuk Ke Akun Anda</h2>
                
                <!-- Form Login -->
                <form class="space-y-6" id="loginForm" action="{{ url('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            id="loginButton">Masuk</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
                        $(document).ready(function () {
                    $('#loginForm').on('submit', function (e) {
                        e.preventDefault(); // Mencegah reload halaman

                        const email = $('#email').val();
                        const password = $('#password').val();
                        const actionUrl = $(this).attr('action');

                        // Tampilkan loading menggunakan SweetAlert
                        Swal.showLoading();

                        $.ajax({
                            url: actionUrl,
                            type: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                email: email,
                                password: password
                            },
                            success: function (response) {
                                Swal.close(); // Tutup loading

                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Login berhasil!',
                                        text: 'Anda akan dialihkan...',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.href = response.redirect;
                                    });
                                }
                            },
                            error: function (xhr) {
                                Swal.close(); // Tutup loading

                                // Tampilkan error dari server
                                const errorMessage = xhr.responseJSON?.message || 'Terjadi masalah pada server. Silakan coba lagi.';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login gagal!',
                                    text: errorMessage,
                                });
                            }
                        });
                    });
                });

        </script>
    </body>
</html>
