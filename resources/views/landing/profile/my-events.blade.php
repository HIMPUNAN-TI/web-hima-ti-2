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
                        <li>Event Saya</li>
                    </ul>
                </div>
                <h1 class="text-5xl font-bold text-white">Event Saya</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="bg-gray-50 px-8 md:px-16 lg:px-32 py-16 lg:py-24">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Riwayat Pendaftaran</h2>
                    <p class="text-gray-600 mt-2">Total {{ $registrations->count() }} pendaftaran event</p>
                </div>
                <a href="{{ route('landing.events.index') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Daftar Event Baru
                </a>
            </div>

            <!-- Events List -->
            @if ($registrations->count() > 0)
                <div class="space-y-4">
                    @foreach ($registrations as $registration)
                        <div class="card bg-white shadow-lg hover:shadow-xl transition-all duration-300">
                            <div class="card-body">
                                <div class="flex flex-col lg:flex-row gap-6">
                                    <!-- Event Image -->
                                    <div class="flex-shrink-0">
                                        <figure class="rounded-lg overflow-hidden w-full lg:w-64 h-48">
                                            <img src="{{ asset('image/landing/event-1.jpg') }}"
                                                alt="{{ $registration->event->title ?? 'Event' }}"
                                                class="w-full h-full object-cover">
                                        </figure>
                                    </div>

                                    <!-- Event Details -->
                                    <div class="flex-grow">
                                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4">
                                            <div>
                                                <h3 class="text-2xl font-bold text-gray-900">
                                                    {{ $registration->event->name ?? 'Event Tidak Ditemukan' }}
                                                </h3>
                                                {{-- <p class="text-lg text-gray-700 mt-1 text-justify">
                                                    {!! $registration->event->description ?? '-' !!}
                                                </p> --}}
                                            </div>

                                            <!-- Status Badge -->
                                            <div class="flex-shrink-0">
                                                @if ($registration->status === 'pending')
                                                    <span class="badge badge-warning badge-lg gap-2">
                                                        <i class="fa-solid fa-clock"></i>
                                                        Menunggu
                                                    </span>
                                                @elseif ($registration->status === 'proses cek')
                                                    <span class="badge badge-info badge-lg gap-2">
                                                        <i class="fa-solid fa-spinner"></i>
                                                        Proses Cek
                                                    </span>
                                                @elseif ($registration->status === 'valid')
                                                    <span class="badge badge-success badge-lg gap-2">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Pendaftaran Valid
                                                    </span>
                                                @elseif ($registration->status === 'ditolak')
                                                    <span class="badge badge-error badge-lg gap-2">
                                                        <i class="fa-solid fa-circle-xmark"></i>
                                                        Pendaftaran Ditolak
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                            <!-- Date -->
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                                    <i class="fa-regular fa-calendar text-primary text-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Tanggal Event</p>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $registration->event ? \Carbon\Carbon::parse($registration->event->date)->format('d M Y') : '-' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Location -->
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                                    <i class="fa-solid fa-location-dot text-primary text-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Lokasi</p>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $registration->event->location ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Price -->
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                                    <i class="fa-solid fa-tag text-primary text-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Harga</p>
                                                    <p class="font-bold text-primary">
                                                        Rp{{ $registration->event ? number_format($registration->event->price, 0, ',', '.') : '0' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Registration Info -->
                                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                            <p class="text-sm text-gray-600 mb-2">
                                                <i class="fa-solid fa-user mr-2 text-primary"></i>
                                                <strong>Pendaftar:</strong> {{ $registration->name }}
                                            </p>
                                            <p class="text-sm text-gray-600 mb-2">
                                                <i class="fa-solid fa-envelope mr-2 text-primary"></i>
                                                <strong>Email:</strong> {{ $registration->email }}
                                            </p>
                                            <p class="text-sm text-gray-600 mb-2">
                                                <i class="fa-solid fa-id-card mr-2 text-primary"></i>
                                                <strong>NIM:</strong> {{ $registration->nim }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <i class="fa-solid fa-clock mr-2 text-primary"></i>
                                                <strong>Tanggal Daftar:</strong>
                                                {{ \Carbon\Carbon::parse($registration->created_at)->format('d F Y, H:i') }}
                                                WIB
                                            </p>
                                        </div>

                                        <!-- Rejection Reason (if rejected) -->
                                        @if ($registration->status === 'ditolak' && $registration->decline_reason)
                                            <div class="alert alert-error mb-4">
                                                <i class="fa-solid fa-circle-exclamation"></i>
                                                <div>
                                                    <p class="font-semibold">Alasan Penolakan:</p>
                                                    <p class="text-sm">{{ $registration->decline_reason }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Action Buttons -->
                                        <div class="flex flex-wrap gap-3">
                                            @if ($registration->event)
                                                <a href="{{ route('landing.events.detail', $registration->event->id) }}"
                                                    class="btn btn-outline btn-primary btn-sm">
                                                    <i class="fa-solid fa-eye mr-2"></i>
                                                    Lihat Detail Event
                                                </a>
                                            @endif

                                            @if ($registration->proof_of_payment)
                                                <a href="{{ asset('image/proof_of_payments/' . $registration->proof_of_payment) }}"
                                                    target="_blank" class="btn btn-outline btn-secondary btn-sm">
                                                    <i class="fa-solid fa-file-invoice mr-2"></i>
                                                    Lihat Bukti Bayar
                                                </a>
                                            @endif

                                            @if ($registration->status === 'valid')
                                                <span class="btn btn-outline btn-success btn-sm pointer-events-none">
                                                    <i class="fa-solid fa-check-double mr-2"></i>
                                                    Terdaftar
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="card bg-white shadow-lg">
                    <div class="card-body text-center py-16">
                        <div class="mb-6">
                            <i class="fa-solid fa-calendar-xmark text-gray-300 text-6xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Event Terdaftar</h3>
                        <p class="text-gray-600 mb-6">Anda belum mendaftar event apapun. Yuk ikuti event menarik dari
                            Himaprodi TI!</p>
                        <a href="{{ route('landing.events.index') }}" class="btn btn-primary">
                            <i class="fa-solid fa-calendar-plus mr-2"></i>
                            Lihat Event Tersedia
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
