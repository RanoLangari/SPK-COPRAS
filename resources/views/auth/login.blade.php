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
            background-image: url('{{ asset('img/kantor.jpeg') }}'); /* Ganti dengan URL gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .login-form {
            background-color: rgba(255, 255, 255, 0.8);
            /* Warna latar belakang form dengan transparansi */
            padding: 20px;
            /* Jarak dalam form */
            border-radius: 10px;
            /* Sudut melengkung pada form */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Bayangan pada form */
        }

    
            
    </style>
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
        
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm login-form"> <!-- Tambahkan class login-form -->
             
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900 ">Masuk Ke Akun Anda</h2>
            <form class="space-y-6" action="{{ url('login') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                        address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
