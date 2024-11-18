<nav class="bg-gray-800" x-data="{ isOpen: false, isProfileOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center"> <!-- Tambahkan flex items-center di sini -->
                    <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="h-12 w-12 mr-4">
                    <a href="/" class="text-white font-bold text-lg">SPK Coprass</a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-nav-link href='/' :active="request()->is('/')">Beranda</x-nav-link>
                        <x-nav-link href='/alternatif' :active="request()->is('alternatif')">Alternatif</x-nav-link>
                        <x-nav-link href='/kriteria' :active="request()->is('kriteria')">Kriteria</x-nav-link>
                        <x-nav-link href='/subkriteria' :active="request()->is('subkriteria')">SubKriteria</x-nav-link>
                        @php
                            $subkriteriaCount = \App\Models\Subkriteria::count();
                        @endphp

                        @if($subkriteriaCount > 0)
                            <x-nav-link href='/penilaian' :active="request()->is('penilaian')">Penilaian</x-nav-link>
                        @else
                            <div x-data="{ showAlert: false }">
                                <a href="#" @click.prevent="showAlert = true" class="text-red-500 hover:text-red-700">Penilaian</a>
                                <div x-show="showAlert" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform translate-y-4" class="bg-red-500 text-white px-4 py-2 rounded-md mt-2">
                                    Isi sub kriteria terlebih dahulu jika ingin mengakses penilaian.
                                </div>
                            </div>
                        @endif
                        <x-nav-link href='/periode' :active="request()->is('periode')">Periode</x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="hidden md:block">
                <div class="ml-4 relative">
                    <button @click="isProfileOpen = !isProfileOpen" type="button"
                        class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-white">
                        <span class="sr-only">Buka menu pengguna</span>
                        <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="{{ Auth::user()->name }}">
                    </button>

                    <!-- Profile Dropdown Menu -->
                    <div x-show="isProfileOpen" @click.away="isProfileOpen = false"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                        <div class="py-2">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 font-semibold">{{ Auth::user()->name }} ({{ Auth::user()->role }})</a>
                            <a href="{{ route('profile.edit', ['id' => Auth::user()->id]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex md:hidden">
                <button @click="isOpen = !isOpen" type="button"
                    class="inline-flex items-center justify-center p-2 text-gray-400 bg-gray-800 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="isOpen" x-transition
        class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <a href="/" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Beranda</a>
            <a href="/alternatif" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Alternatif</a>
            <a href="/kriteria" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Kriteria</a>
            <a href="/subkriteria" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">SubKriteria</a>
            <a href="/penilaian" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Penilaian</a>
        </div>

        <!-- Mobile Profile & Logout -->
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="{{ Auth::user()->name }}">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium leading-none text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium leading-none text-gray-400">{{ Auth::user()->role }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1 px-2">
                <a href="{{ route('profile.edit', ['id' => Auth::user()->id]) }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>