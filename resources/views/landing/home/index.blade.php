@extends('layouts.landing_layout')

@section('content')
    {{-- ============================= Hero Section ============================= --}}
    <section class="hero min-h-screen" id="home" style="background-image: url({{ asset('image/landing/dash6.png') }});">
        <div class="hero-overlay bg-[rgba(1,64,151,0.75)]"></div>

        <div class="hero-content text-neutral-content text-center">
            <div class="max-w-4xl">
                <div class="flex flex-wrap lg:flex-nowrap items-center justify-center mx-auto gap-2 lg:gap-4 w-fit max-w-full bg-white/75 rounded-md shadow-lg py-2 px-4 mb-8">
                    <img src="{{ asset('image/landing/logo/INSTITUT_TEKNOLOGI_DAN_BISNIS_STIKOM_BALI.png') }}" alt="Logo STIKOM Bali"
                        class="w-32 h-32 lg:w-48 lg:h-48 object-contain">
                
                    <img src="{{ asset('image/landing/logo/HIMA.png') }}" alt="Logo Himaprodi TI"
                        class="w-32 h-32 lg:w-48 lg:h-48 object-contain">
                    
                    <img src="{{ asset('image/landing/logo/KABINET_CAKRA_PRAGNYA_FULL-LEBAR.png') }}" alt="Logo Kabinet"
                        class="w-32 h-32 lg:w-48 lg:h-48 object-contain">
                </div>
                <h1 class="mb-5 text-5xl font-bold text-white">Himaprodi ITB Stikom Bali</h1>
                <p class="mb-5">
                    Informasi Event dan Kegiatan Mahasiswa Program Studi Teknologi Informasi
                </p>
                <div class="flex justify-center items-center gap-4">
                    <a href="/#about-us" class="btn btn-outline">Tentang Kami</a>
                    <a href="/#event" class="btn btn-soft btn-primary">Event Kami</a>
                </div>
            </div>
        </div>
    </section>
    {{-- ============================= End Hero Section ============================= --}}


    {{-- ============================= Visi & Misi Section ============================= --}}

    <section class="py-20 bg-[rgba(1,64,151,1)]" id="visi-misi">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4 text-white">Visi & Misi</h2>
                <div class="w-24 h-1 bg-white mx-auto rounded-full"></div>
                <p class="mt-4 text-blue-100">Landasan perjuangan Himaprodi ITB STIKOM Bali dalam mewujudkan aspirasi mahasiswa.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div class="card bg-white/95 shadow-xl border-t-4 border-blue-400 h-full">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-3 bg-blue-100 rounded-lg text-[rgba(1,64,151,1)]">
                                <svg xmlns="" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-2xl font-bold text-gray-800">Visi Kami</h3>
                        </div>
                        <p class="text-lg italic leading-relaxed text-gray-700">
                            “Membangun Himaprodi TI sebagai ruang inovasi, kreativitas, dan prestasi mahasiswa, guna membentuk generasi unggul berdaya saing global, serta siap berkontribusi nyata dalam mewujudkan Indonesia Emas 2045.”
                        </p>
                    </div>
                </div>

                <div class="card bg-white/95 shadow-xl border-t-4 border-blue-400 h-full">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-3 bg-blue-100 rounded-lg text-[rgba(1,64,151,1)]">
                                <svg xmlns="" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-2xl font-bold text-gray-800">Misi Kami</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex gap-3">
                                <span class="badge bg-[rgba(1,64,151,1)] text-white border-none font-bold text-lg p-3">1</span>
                                <p class="text-gray-700">Membangun lingkungan internal yang inklusif dan berlandaskan rasa kekeluargaan untuk mendorong partisipasi aktif setiap anggota.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="badge bg-[rgba(1,64,151,1)] text-white border-none font-bold text-lg p-3">2</span>
                                <p class="text-gray-700">Menyediakan wadah, program, dan kegiatan yang mendorong kreativitas serta inovasi mahasiswa dalam bidang akademik maupun non akademik.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="badge bg-[rgba(1,64,151,1)] text-white border-none font-bold text-lg p-3">3</span>
                                <p class="text-gray-700">Membina kemampuan kepemimpinan, kerja sama tim, dan kolaborasi mahasiswa secara efektif, dari tingkat lokal hingga nasional.</p>
                            </li>
                            <li class="flex gap-3">
                                <span class="badge bg-[rgba(1,64,151,1)] text-white border-none font-bold text-lg p-3">4</span>
                                <p class="text-gray-700">Melaksanakan kegiatan sosial dan pengabdian masyarakat yang berdampak positif, mendukung tercapainya Indonesia Emas 2045.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================= End Visi & Misi Section ============================= --}}


    {{-- ============================= About Us Section ============================= --}}
    <section
        class="bg-base-200 px-8 md:px-16 lg:px-32 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-[45%_55%] gap-12 items-center"
        id="about-us">
        <div class="max-w-xl">
            <h2 class="text-4xl font-bold max-w-md capitalize">Berbagai Macam Kegiatan Event Seru dan Menarik dari
                Himaprodi TI!</h2>
            <p class="mt-5 text-base font-normal italic text-gray-600 max-w-lg">
                Yuk, ikuti acara dari kami! Akan ada banyak kegiatan menarik dan kesempatan untuk bertemu dengan
                orang-orang hebat. Jangan sampai ketinggalan!
            </p>

            <div class="my-7">
                <div class="flex items-start gap-4 mt-6">
                    <div class="bg-sky-400/20 rounded-lg w-10 h-10 flex-shrink-0 flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-primary text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold">SKKM Untuk Kebutuhan Sidang Akhir Untuk Skripsi.</h4>
                        <p class="mt-2 text-sm text-gray-600">
                            Kumpulin poin SKKM biar nanti pas mau sidang skripsi nggak repot lagi. Yuk mulai dari
                            sekarang!
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-4 mt-6">
                    <div class="bg-sky-400/20 rounded-lg w-10 h-10 flex-shrink-0 flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-primary text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold">Kesempatan Bertanya Dengan Narasumber Terpercaya.</h4>
                        <p class="mt-2 text-sm text-gray-600">
                            Nggak perlu ragu buat nanya! Langsung aja ngobrol sama narasumber keren dan dapetin insight
                            baru.
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-4 mt-6">
                    <div class="bg-sky-400/20 rounded-lg w-10 h-10 flex-shrink-0 flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-primary text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold">Banyak Informasi dan Relasi di Event yang Kamu Ikuti Loh!.</h4>
                        <p class="mt-2 text-sm text-gray-600">
                            Selain dapet ilmu, kamu juga bisa nambah kenalan dan relasi baru dari tiap event yang
                            diikutin. Seru kan?
                        </p>
                    </div>
                </div>
            </div>

            <a href="#event" class="btn btn-primary px-8 mt-2 text-white">
                Cek Event <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 gap-4 h-[512px]">
            <!-- Gambar Kiri Atas - Tinggi -->
            <div class="relative overflow-hidden rounded-lg row-span-2">
                <img src="{{ asset('image/landing/dash7.jpg') }}" alt="About Us" class="w-full h-full object-cover">
            </div>
            <!-- Gambar Kanan Atas - Pendek -->
            <div class="relative overflow-hidden rounded-lg">
                <img src="{{ asset('image/landing/dash2.jpg') }}" alt="About Us" class="w-full h-full object-cover">
            </div>
            <!-- Gambar Kanan Bawah - Pendek -->
            <div class="relative overflow-hidden rounded-lg">
                <img src="{{ asset('image/landing/dash3.jpg') }}" alt="About Us" class="w-full h-full object-cover">
            </div>
        </div>
    </section>
    {{-- ============================= End About Us Section ============================= --}}

    {{-- ============================= Event Section ============================= --}}
    <section class="bg-white px-8 md:px-16 lg:px-32 py-16 lg:py-24" id="event">
        
    <!-- Section Title & Description -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-4xl font-bold">Event Kami</h2>
            <div class="w-16 h-1 bg-primary mx-auto mt-3"></div>
            <p class="mt-6 text-base text-gray-600">
                Jangan lewatkan berbagai event menarik yang kami tawarkan untuk mengembangkan skill dan memperluas
                network Anda
            </p>
        </div>

        <!-- Event Geteksi Local -->
        <div class="mb-12">

            <div class="bg-white rounded-lg overflow-hidden grid grid-cols-1 lg:grid-cols-6 gap-6 shadow-lg mb-12">
                <div class="lg:col-span-3 relative">
                    <span class="absolute top-4 left-4 bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full z-10">
                        EVENT TERKINI
                    </span>
                    <img src="{{ asset('image/landing/dash7.jpg') }}" alt="GETEKSI VOL. 3" class="w-full h-full object-cover min-h-[300px]">
                </div>

                <div class="lg:col-span-3 p-6 lg:p-8 flex flex-col justify-between">
                    <div>
                        <span class="badge badge-outline badge-success text-sm font-semibold uppercase tracking-wide">TERSEDIA</span>
                        <h3 class="text-2xl lg:text-3xl font-bold mt-2 mb-4">GETEKSI VOL. 3</h3>
                        <div class="space-y-3 mb-6 text-gray-600">
                            <div class="flex items-center gap-3"><i class="fa-regular fa-calendar text-primary"></i> <span>25 Mei 2026</span></div>
                            <div class="flex items-center gap-3"><i class="fa-solid fa-location-dot text-primary"></i> <span>Aula ITB STIKOM BALI</span></div>
                            <div class="flex items-center gap-3"><i class="fa-solid fa-ticket text-primary"></i> <span>Rp30.000</span></div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Bergabunglah dalam workshop intensif selama satu hari untuk mempelajari tren desain terbaru.
                        </p>
                    </div>
                    <div class="mt-6">
                        <a href="#" class="btn btn-primary text-white px-6">Lihat Detail <i class="fa-solid fa-arrow-right ml-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="mb-24"> 
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Kompetisi Geteksi</h2>
                        <p class="text-gray-500 text-base mt-1">Pilih kategori lomba yang ingin Anda ikuti</p>
                    </div>
                    <span class="bg-primary/10 text-primary px-5 py-1.5 rounded-full text-sm font-bold shadow-sm">
                        2 Lomba Tersedia
                    </span>
                </div>

                <div class="flex flex-wrap justify-center gap-10">
                    
                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 w-full md:w-[calc(50%-1.25rem)] lg:w-[450px]">
                        <img src="{{ asset('image/landing/dash7.jpg') }}" alt="UI/UX" class="w-full h-56 object-cover">
                        <div class="p-8">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-black text-primary uppercase tracking-widest">Design</span>
                                <span class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-lg font-bold">5 HARI LAGI</span>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 text-gray-800">UI/UX Championship</h4>
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center gap-4 text-gray-600">
                                    <i class="fa-solid fa-users text-lg text-primary/60"></i> 
                                    <span class="font-medium">Tim (Maks. 3 Orang)</span>
                                </div>
                                <div class="flex items-center gap-4 text-gray-600">
                                    <i class="fa-solid fa-trophy text-lg text-yellow-500"></i> 
                                    <span class="font-medium">Total Hadiah Rp5.000.000</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary btn-lg btn-block text-white shadow-lg border-none hover:brightness-110">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 w-full md:w-[calc(50%-1.25rem)] lg:w-[450px]">
                        <img src="{{ asset('image/landing/dash7.jpg') }}" alt="Web Dev" class="w-full h-56 object-cover">
                        <div class="p-8">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-black text-primary uppercase tracking-widest">Code</span>
                                <span class="text-xs bg-blue-100 text-blue-600 px-3 py-1 rounded-lg font-bold">12 HARI LAGI</span>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 text-gray-800">Competitive Web Dev</h4>
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center gap-4 text-gray-600">
                                    <i class="fa-solid fa-user text-lg text-primary/60"></i> 
                                    <span class="font-medium">Individu</span>
                                </div>
                                <div class="flex items-center gap-4 text-gray-600">
                                    <i class="fa-solid fa-trophy text-lg text-yellow-500"></i> 
                                    <span class="font-medium">Total Hadiah Rp3.500.000</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary btn-lg btn-block text-white shadow-lg border-none hover:brightness-110">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Event Famgath Local -->
        <div class="mb-12">
            <div class="relative bg-white rounded-lg overflow-hidden grid grid-cols-1 lg:grid-cols-6 gap-6 shadow-lg mb-12 border border-gray-100">
                
                <div class="absolute inset-0 z-50 flex items-center justify-center pointer-events-none overflow-hidden">
                    <div class="absolute inset-0 bg-white/40 backdrop-blur-[2px]"></div>
                    
                    <h1 class="relative text-6xl lg:text-9xl font-black text-primary/20 uppercase tracking-tighter -rotate-12 whitespace-nowrap select-none">
                        Coming Soon • Coming Soon • Coming Soon
                    </h1>
                </div>

                <div class="lg:col-span-3 relative opacity-50"> <span class="absolute top-4 left-4 bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full z-10">
                        EVENT TERKINI
                    </span>
                    <img src="{{ asset('image/landing/dash7.jpg') }}" alt="GETEKSI VOL. 3" class="w-full h-full object-cover min-h-[300px]">
                </div>

                <div class="lg:col-span-3 p-6 lg:p-8 flex flex-col justify-between opacity-50">
                    <div>
                        <span class="badge badge-outline badge-accent text-sm font-semibold uppercase tracking-wide">COMING SOON</span>
                        <h3 class="text-2xl lg:text-3xl font-bold mt-2 mb-4 text-gray-400">Famgath TI 2026</h3>
                        <div class="space-y-3 mb-6 text-gray-400">
                            <div class="flex items-center gap-3"><i class="fa-regular fa-calendar"></i> <span>-</span></div>
                            <div class="flex items-center gap-3"><i class="fa-solid fa-location-dot"></i> <span>-</span></div>
                            <div class="flex items-center gap-3"><i class="fa-solid fa-ticket"></i> <span>-</span></div>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed italic">
                            Detail acara akan segera diumumkan. Pantau terus informasinya!
                        </p>
                    </div>
                    <div class="mt-6">
                        <button class="btn btn-disabled bg-gray-200 text-gray-400 px-6 cursor-not-allowed">
                            Lihat Detail <i class="fa-solid fa-lock ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Famgath 2025 Full Width -->
        @if ($highlightedEvent)
            <div class="mb-12">
                <div class="bg-white rounded-lg overflow-hidden grid grid-cols-1 lg:grid-cols-6 gap-6"
                    style="box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);">
                    <!-- Event Image -->
                    <div class="lg:col-span-3 relative">
                        <span
                            class="absolute top-4 left-4 bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full z-10">
                            EVENT TERKINI
                        </span>
                        <img src="{{ asset('image/events/posters/' . $highlightedEvent->poster) }}"
                            alt="{{ $highlightedEvent->name }}"
                            class="w-full h-full object-cover min-h-[300px] max-h-[400px] lg:max-h-[500px] lg:min-h-full">
                    </div>

                    <!-- Event Details -->
                    <div class="lg:col-span-3 p-6 lg:p-8 flex flex-col justify-between">
                        <div>
                            @php
                                $eventDate = \Carbon\Carbon::parse($highlightedEvent->date);
                                $today = \Carbon\Carbon::today();
                                $isClosed = $eventDate->isBefore($today);
                                $statusText = $isClosed ? 'TUTUP' : 'TERSEDIA';
                                $badgeColor = $isClosed ? 'badge-error' : 'badge-success';
                            @endphp

                            <span
                                class="badge badge-outline {{ $badgeColor }} text-sm font-semibold uppercase tracking-wide">
                                {{ $statusText }}
                            </span>

                            <h3 class="text-2xl lg:text-3xl font-bold mt-2 mb-4">{{ $highlightedEvent->name }}</h3>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-3 text-gray-600">
                                    <i class="fa-regular fa-calendar text-primary"></i>
                                    <span
                                        class="text-sm">{{ \Carbon\Carbon::parse($highlightedEvent->date)->translatedFormat('d F Y') }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-gray-600">
                                    <i class="fa-solid fa-location-dot text-primary"></i>
                                    <span class="text-sm">{{ $highlightedEvent->location }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-gray-600">
                                    <i class="fa-solid fa-ticket text-primary"></i>
                                    <span
                                        class="text-sm">Rp{{ number_format($highlightedEvent->price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <p class="text-gray-600 text-sm leading-relaxed">
                                {!! $highlightedEvent->description !!}
                            </p>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('landing.events.detail', $highlightedEvent->id) }}"
                                class="btn btn-primary text-white px-6">
                                Lihat Detail <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Other Events - Grid 3 Columns -->
        @if ($events->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="relative">
                            @php
                                $eventDate = \Carbon\Carbon::parse($event->date);
                                $today = \Carbon\Carbon::today();
                                $isClosed = $eventDate->isBefore($today);
                                $statusText = $isClosed ? 'TUTUP' : 'TERSEDIA';
                                $bgColor = $isClosed ? 'bg-red-500' : 'bg-green-500';
                            @endphp

                            <span
                                class="absolute top-4 left-4 {{ $bgColor }} text-white text-xs font-semibold px-3 py-1 rounded-full z-10">
                                {{ $statusText }}
                            </span>
                            <img src="{{ asset('image/events/posters/' . $event->poster) }}" alt="{{ $event->name }}"
                                class="w-full h-64 object-cover">
                        </div>
                        <div class="p-5">
                            <span
                                class="badge badge-outline badge-primary text-xs font-semibold uppercase tracking-wide">Event</span>
                            <h4 class="text-lg font-bold mt-2 mb-3">{{ $event->name }}</h4>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <i class="fa-regular fa-calendar text-primary text-sm"></i>
                                    <span
                                        class="text-xs">{{ \Carbon\Carbon::parse($highlightedEvent->date)->translatedFormat('d F Y') }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-600">
                                    <i class="fa-solid fa-location-dot text-primary text-sm"></i>
                                    <span class="text-xs">{{ $event->location }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-600">
                                    <i class="fa-solid fa-ticket text-primary text-sm"></i>
                                    <span class="text-xs">Rp{{ number_format($event->price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {!! $event->description !!}
                            </p>

                            <a href="{{ route('landing.events.detail', $event->id) }}"
                                class="btn btn-primary btn-sm text-white w-full">
                                Lihat Detail <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($events->isNotEmpty())
            <!-- Load More Button -->
            <div class="text-center mt-12">
                <a href="{{ route('landing.events.index') }}" class="btn btn-outline btn-primary px-8">
                    Lihat Semua Event <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        @endif
    </section>
    {{-- ============================= End Event Section ============================= --}}
@endsection
