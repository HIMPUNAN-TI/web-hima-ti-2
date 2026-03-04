@extends('layouts.landing_layout')

@section('content')
    {{-- ============================= Hero Section ============================= --}}
    <section class="hero min-h-screen" id="home" style="background-image: url({{ asset('image/landing/dash6.png') }});">
        <div class="hero-overlay bg-[rgba(1,64,151,0.75)]"></div>

        <div class="hero-content text-neutral-content text-center">
            <div class="max-w-4xl">
                <div class="flex flex-wrap lg:flex-nowrap items-center justify-center mx-auto gap-2 lg:gap-4 w-fit max-w-full bg-white/75 rounded-md shadow-lg py-2 px-4 mb-8">
                    <img src="{{ asset('image/landing/logo/logo_raw.png') }}" alt="Logo STIKOM Bali"
                        class="w-32 h-32 lg:w-48 lg:h-48 object-contain">
                    
                    <img src="{{ asset('image/landing/logo/hima.png') }}" alt="Logo Himaprodi TI"
                        class="w-32 h-32 lg:w-48 lg:h-48 object-contain">
                    
                    <img src="{{ asset('image/landing/logo/Kabinet Cakra Pragnya.png') }}" alt="Logo Kabinet"
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

        <!-- Recent Event - Full Width -->
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
