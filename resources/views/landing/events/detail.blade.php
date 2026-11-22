@extends('layouts.landing_layout')

@section('page-title')
    <section class="hero min-h-[40vh] mt-[73px] justify-items-start"
        style="background-image: url({{ asset('image/landing/dash5.png') }});">
        <div class="hero-overlay bg-[rgba(1,64,151,0.75)]"></div>

        <div class="hero-content text-neutral-content text-center px-8 md:px-16 lg:px-32">
            <div class="max-w-4xl">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('landing.index') }}">Beranda</a></li>
                        <li><a href="{{ route('landing.events.index') }}">Event</a></li>
                        <li>Detail</li>
                    </ul>
                </div>
                <h1 class="text-5xl font-bold text-white">Detail Event</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{-- ============================= Event Detail Section ============================= --}}
    <section class="bg-white px-8 md:px-16 lg:px-32 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Left Column - Event Poster -->
            <div class="w-full">
                <div class="sticky top-24">
                    <img src="{{ asset('image/events/posters/' . $event->poster) }}" alt="{{ $event->name }}"
                        class="w-full rounded-lg shadow-xl">
                </div>
            </div>

            <!-- Right Column - Event Details -->
            <div class="w-full">
                <!-- Event Title -->
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    {{ $event->name }}
                </h1>

                <!-- Event Price -->
                <div class="mb-6">
                    @if ($event->isFree())
                        <div class="flex items-center gap-2">
                            <span class="badge badge-success badge-lg text-white font-bold text-xl px-5 py-4">GRATIS</span>
                            <span class="text-sm text-gray-500 font-medium">(Tanpa biaya pendaftaran)</span>
                        </div>
                    @else
                        <p class="text-3xl font-bold text-primary">Rp{{ number_format($event->price, 0, ',', '.') }}</p>
                    @endif
                </div>

                <!-- Event Info Cards -->
                <div class="space-y-4 mb-8">
                    <!-- Event Date Info -->
                    <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg">
                        <i class="fa-regular fa-calendar text-primary text-xl"></i>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Acara</p>
                            <p class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}</p>
                        </div>
                    </div>

                    <!-- Quota Info (Requirement 3) -->
                    <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg">
                        <i class="fa-solid fa-users text-primary text-xl"></i>
                        <div>
                            <p class="text-sm text-gray-600">Kuota Peserta</p>
                            <p class="font-semibold text-gray-900 flex items-center gap-2">
                                @if ($event->quota)
                                    <span>{{ $event->registered_count }} / {{ $event->quota }} Peserta Terdaftar</span>
                                    @if ($event->isFull())
                                        <span class="badge badge-error badge-sm text-white">Kuota Penuh</span>
                                    @else
                                        <span class="badge badge-success badge-sm text-white">Sisa {{ $event->remaining_quota }}</span>
                                    @endif
                                @else
                                    <span>{{ $event->registered_count }} Peserta (Kuota Terbuka)</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Location Info -->
                    <a href="{{ $event->maps }}" target="_blank" rel="noopener noreferrer">
                        <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg">
                            <i class="fa-solid fa-location-dot text-primary text-xl"></i>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">Lokasi</p>
                                <p class="font-semibold text-gray-900">{{ $event->location }}</p>
                            </div>
                            <i class="fa-solid fa-arrow-up-right-from-square text-primary text-lg"></i>
                        </div>
                    </a>
                </div>

                <!-- Event Description -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Tentang Event</h2>
                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                        <p class="text-gray-600 text-sm mb-4">
                            {!! $event->description !!}
                        </p>
                    </div>
                </div>

                <!-- Registration Info -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-info text-yellow-600 text-xl mt-1"></i>
                        <div>
                            <p class="font-semibold text-gray-900 mb-1">Informasi Pendaftaran</p>
                            <p class="text-sm text-gray-700">
                                Pendaftaran Terakhir
                                <strong>{{ \Carbon\Carbon::parse($event->regist_end_date)->format('d F Y') }}</strong>,
                                Pendaftaran segera berakhir. Yuk,
                                daftar sekarang sebelum terlambat!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CTA Section (Requirement 3: Pendaftaran Ganda, Tenggat, Kuota) -->
                @if (isset($userRegistration) && $userRegistration)
                    <div class="alert alert-info shadow-lg rounded-2xl p-6 mb-6">
                        <i class="fa-solid fa-circle-check text-3xl text-info-content"></i>
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-900">Anda Sudah Terdaftar pada Kegiatan Ini</h3>
                            <p class="text-sm text-gray-700 mt-1">
                                Nomor Pendaftaran: <span class="font-mono font-bold text-primary">{{ $userRegistration->registration_code ?? '-' }}</span>
                            </p>
                            <p class="text-xs text-gray-600 mt-0.5">
                                Status: <span class="badge badge-primary text-white font-semibold">{{ ucfirst($userRegistration->status) }}</span>
                            </p>
                        </div>
                        <div class="flex-none">
                            <a href="{{ route('landing.profile.my-events') }}" class="btn btn-primary text-white shadow-md">
                                <i class="fa-solid fa-ticket mr-1"></i>
                                Event Saya
                            </a>
                        </div>
                    </div>
                @elseif ($event->isDeadlinePassed())
                    <div class="alert alert-error text-white shadow-md rounded-2xl mb-6">
                        <i class="fa-solid fa-clock text-2xl"></i>
                        <div>
                            <h4 class="font-bold">Pendaftaran Telah Ditutup</h4>
                            <p class="text-sm">Batas waktu pendaftaran berakhir pada {{ \Carbon\Carbon::parse($event->regist_end_date)->format('d F Y') }}.</p>
                        </div>
                    </div>
                    <button class="btn btn-disabled btn-block px-10 text-gray-400 cursor-not-allowed" disabled>
                        <i class="fa-solid fa-lock mr-2"></i>
                        Pendaftaran Telah Ditutup
                    </button>
                @elseif ($event->isFull())
                    <div class="alert alert-warning shadow-md rounded-2xl mb-6">
                        <i class="fa-solid fa-users-slash text-2xl"></i>
                        <div>
                            <h4 class="font-bold">Kuota Kegiatan Penuh</h4>
                            <p class="text-sm">Mohon maaf, kuota pendaftaran maksimal ({{ $event->quota }} peserta) telah terpenuhi.</p>
                        </div>
                    </div>
                    <button class="btn btn-disabled btn-block px-10 text-gray-400 cursor-not-allowed" disabled>
                        <i class="fa-solid fa-ban mr-2"></i>
                        Kuota Peserta Penuh
                    </button>
                @elseif (!Auth::check())
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <p class="text-gray-700 mb-4 font-medium">
                            Silakan masuk atau daftar akun terlebih dahulu untuk mendaftar pada kegiatan ini:
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('register') }}" class="btn btn-primary text-white flex-1 shadow-md">
                                <i class="fa-solid fa-user-plus mr-2"></i>
                                Registrasi Akun
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline btn-primary flex-1">
                                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                                Login
                            </a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('landing.events.register', $event->id) }}"
                        class="btn btn-primary btn-block px-10 text-white shadow-lg text-lg">
                        <i class="fa-solid fa-pen-to-square mr-2"></i>
                        {{ $event->isFree() ? 'Daftar Kegiatan Gratis' : 'Daftar Sekarang' }}
                    </a>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-12">
            <a href="{{ route('landing.events.index') }}" class="btn btn-outline btn-primary">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Kembali ke Daftar Event
            </a>
        </div>
    </section>
@endsection
