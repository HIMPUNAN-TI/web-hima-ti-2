@extends('layouts.landing_layout')

@section('page-title')
    <section class="hero min-h-[40vh] mt-[73px] justify-items-start"
        style="background-image: url({{ asset('image/landing/dash6.png') }});">
        <div class="hero-overlay bg-[rgba(1,64,151,0.75)]"></div>

        <div class="hero-content text-neutral-content text-center px-8 md:px-16 lg:px-32">
            <div class="max-w-4xl">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('landing.index') }}">Beranda</a></li>
                        <li>Event</li>
                    </ul>
                </div>
                <h1 class="text-5xl font-bold text-white">Semua Event Kami</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{-- ============================= Event Section ============================= --}}
    <section class="bg-white px-8 md:px-16 lg:px-32 py-16 lg:py-24" id="event">
        <!-- Section Title & Description -->
        <div class="mb-8">
            <h2 class="text-4xl font-bold mb-4">Event Terkini</h2>
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

            <div class="bg-white rounded-lg overflow-hidden grid grid-cols-1 lg:grid-cols-6 gap-6 shadow-lg mb-12">
                <div class="lg:col-span-3 relative">
                    <span class="absolute top-4 left-4 bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full z-10">
                        EVENT TERKINI
                    </span>
                    <img src="{{ asset('image/landing/dash7.jpg') }}" alt="GETEKSI VOL. 3" class="w-full h-full object-cover min-h-[300px]">
                </div>

                <div class="lg:col-span-3 p-6 lg:p-8 flex flex-col justify-between">
                    <div>
                        <span class="badge badge-outline badge-accent text-sm font-semibold uppercase tracking-wide">COOMING SOON</span>
                        <h3 class="text-2xl lg:text-3xl font-bold mt-2 mb-4">Famgath TI 2026</h3>
                        <div class="space-y-3 mb-6 text-gray-600">
                            <div class="flex items-center gap-3"><i class="fa-regular fa-calendar text-primary"></i> <span>-</span></div>
                            <div class="flex items-center gap-3"><i class="fa-solid fa-location-dot text-primary"></i> <span>-</span></div>
                            <div class="flex items-center gap-3"><i class="fa-solid fa-ticket text-primary"></i> <span>-</span></div>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            -
                        </p>
                    </div>
                    <div class="mt-6">
                        <a href="#" class="btn btn-primary text-white px-6">Lihat Detail <i class="fa-solid fa-arrow-right ml-2"></i></a>
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

        @if ($events->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-3xl font-bold mb-4">Event Lainnya</h2>
            </div>

            <!-- Other Events - Grid 3 Columns -->
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
                                        class="text-xs">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</span>
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

        <!-- Load More Button -->
        <div class="text-center mt-12">
            <a href="{{ route('landing.index') }}" class="btn btn-outline btn-primary px-8">
                Kembali <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>
@endsection
