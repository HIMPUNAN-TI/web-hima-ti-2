<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Beranda' }} - Himaprodi TI ITB STIKOM Bali</title>
    <link rel="icon" href="{{ asset('tabler/static/logo/hima.png') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet" />

    @stack('styles')
</head>

<body class="overflow-x-hidden">
    {{-- ============================= Navbar ============================= --}}
    <nav class="navbar bg-white shadow-xl py-3 px-6 md:px-16 lg:px-32 fixed top-0 left-0 right-0 z-50" id="navbar">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="-1"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li>
                        <a href="{{ route('landing.index') }}"
                            class="{{ Route::currentRouteName() == 'landing.index' ? 'text-primary font-semibold' : '' }}">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('landing.about.index') }}"
                            class="{{ Route::currentRouteName() == 'landing.about.index' ? 'text-primary font-semibold' : '' }}">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('landing.events.index') }}"
                            class="{{ Route::currentRouteName() == 'landing.events.index' ? 'text-primary font-semibold' : '' }}">
                            Event
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('landing.contact.index') }}"
                            class="{{ Route::currentRouteName() == 'landing.contact.index' ? 'text-primary font-semibold' : '' }}">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>
            <a href="{{ route('landing.index') }}" class="inline-flex items-center gap-3">
                <img src="{{ asset('image/landing/logo/hima.png') }}" alt="Logo" class="w-10 h-10" />
                <span class="text-xl text-primary font-bold hidden lg:inline">Himaprodi TI</span></a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 text-gray-800">
                <li>
                    <a href="{{ route('landing.index') }}"
                        class="{{ Route::currentRouteName() == 'landing.index' ? 'text-primary font-semibold' : '' }}">
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('landing.about.index') }}"
                        class="{{ Route::currentRouteName() == 'landing.about.index' ? 'text-primary font-semibold' : '' }}">
                        Tentang Kami
                    </a>
                </li>
                <li>
                    <a href="{{ route('landing.events.index') }}"
                        class="{{ Route::currentRouteName() == 'landing.events.index' ? 'text-primary font-semibold' : '' }}">
                        Event
                    </a>
                </li>
                <li>
                    <a href="{{ route('landing.contact.index') }}"
                        class="{{ Route::currentRouteName() == 'landing.contact.index' ? 'text-primary font-semibold' : '' }}">
                        Kontak
                    </a>
                </li>
            </ul>
        </div>
        <div class="navbar-end">
            @auth
                <!-- Dropdown untuk user yang sudah login -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-primary px-8">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow mt-4">
                        <li>
                            <a href="{{ route('landing.profile.my-events') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                Event Saya
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 text-red-500 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- Tombol login untuk user yang belum login -->
                <a href="{{ route('login') }}" class="btn btn-primary px-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <span>Login</span>
                </a>
            @endauth
        </div>
    </nav>
    {{-- ============================= End Navbar ============================= --}}



    {{-- ============================= Page Title ============================= --}}
    @yield('page-title')
    {{-- ============================= End Page Title ============================= --}}



    {{-- ============================= Content ============================= --}}
    @yield('content')
    {{-- ============================= End Content ============================= --}}



    {{-- ============================= Footer ============================= --}}
    <footer class="bg-[rgb(18,24,39)] text-white px-8 md:px-16 lg:px-32 py-12">
        <div class="max-w-7xl w-full mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <!-- Logo & Description Section -->
                <div class="lg:col-span-1">
                    <a href="{{ route('landing.index') }}" class="inline-flex items-center gap-3 mb-4">
                        <img src="{{ asset('image/landing/logo/hima.png') }}" alt="Logo Hima" class="w-12 h-12">
                        <div>
                            <div class="text-xl font-bold">Himaprodi TI</div>
                            <div class="text-sm opacity-60">ITB STIKOM BALI</div>
                        </div>
                    </a>
                    <p class="text-sm opacity-80 leading-relaxed">
                        Informasi Event dan Kegiatan Mahasiswa Program Studi Teknologi Informasi
                    </p>
                    <p class="text-xs opacity-60 mt-4">
                        <i class="fa-solid fa-location-dot text-primary"></i> Jl Raya Puputan No. 86, Renon, Denpasar,
                        Bali 80226
                    </p>
                    <p class="text-xs opacity-60 mt-2">
                        <i class="fa-solid fa-phone text-primary"></i> +62 361 244445
                    </p>
                    <p class="text-xs opacity-60 mt-2">
                        <i class="fa-regular fa-envelope text-primary"></i> himati@stikom-bali.ac.id
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h6 class="font-semibold text-base mb-4">Tautan Singkat</h6>
                    <ul class="space-y-2">
                        <li><a href="{{ route('landing.index') }}"
                                class="text-sm opacity-70 hover:opacity-100 transition">Beranda</a></li>
                        <li><a href="{{ route('landing.about.index') }}"
                                class="text-sm opacity-70 hover:opacity-100 transition">Tentang Kami</a>
                        </li>
                        <li><a href="{{ route('landing.events.index') }}"
                                class="text-sm opacity-70 hover:opacity-100 transition">Event</a></li>
                        <li><a href="{{ route('landing.contact.index') }}"
                                class="text-sm opacity-70 hover:opacity-100 transition">Kontak</a></li>
                    </ul>
                </div>

                <!-- Ikuti Kami -->
                <div>
                    <h6 class="font-semibold text-base mb-4">Ikuti Kami</h6>
                    <div class="flex gap-3">
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded transition">
                            <i class="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded transition">
                            <i class="fa-brands fa-instagram text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded transition">
                            <i class="fa-brands fa-tiktok text-sm"></i>
                        </a>
                        <a href="#"
                            class="w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded transition">
                            <i class="fa-brands fa-youtube text-sm"></i>
                        </a>
                    </div>
                    <div class="mt-6">
                        <p class="text-sm mb-2 opacity-80">Dapatkan update event terbaru?</p>
                        <div class="flex gap-2">
                            <input type="email" placeholder="Email Anda"
                                class="flex-1 px-3 py-2 bg-white/10 border border-white/20 rounded text-sm focus:outline-none focus:border-white/40">
                            <button
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-sm font-medium transition">
                                Kirim
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div
                class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-sm opacity-60">
                <p>© 2025 Himaprodi TI ITB STIKOM Bali. All rights reserved.</p>
            </div>
        </div>
    </footer>
    {{-- ============================= End Footer ============================= --}}



    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <script>
        // Example: Display a success alert when the page loads
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        // Example: Display an error alert when the page loads
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    </script>

    @stack('scripts')
</body>

</html>
