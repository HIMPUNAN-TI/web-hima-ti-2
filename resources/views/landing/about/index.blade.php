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
                        <li>Tentang Kami</li>
                    </ul>
                </div>
                <h1 class="text-5xl font-bold text-white">Tentang Kami</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
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

            <a href="{{ route('landing.events.index') }}" class="btn btn-primary px-8 mt-2 text-white">
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
@endsection
