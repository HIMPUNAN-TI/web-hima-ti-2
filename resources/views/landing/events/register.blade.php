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
                        <li><a href="{{ route('landing.events.detail', $event->id) }}">Detail</a></li>
                        <li>Pendaftaran</li>
                    </ul>
                </div>
                <h1 class="text-5xl font-bold text-white">Pendaftaran Event</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{-- ============================= Event Registration Section ============================= --}}
    <section class="bg-gray-50 px-8 md:px-16 lg:px-32 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Event Summary Card -->
            <div class="w-full">
                <div class="sticky top-24">
                    <div class="card bg-white shadow-xl">
                        <figure>
                            <img src="{{ asset('image/events/posters/' . $event->poster) }}" alt="{{ $event->title }}"
                                class="w-full object-cover" style="height: 400px;">
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title text-2xl text-gray-900">{{ $event->title }}</h2>

                            <div class="divider my-2"></div>

                            <!-- Event Details -->
                            <div class="space-y-3">
                                <!-- Date -->
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-calendar text-primary text-lg"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Nama Acara</p>
                                        <p class="font-semibold text-gray-900">
                                            {{ $event->name }}</p>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-tag text-primary text-lg"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Harga</p>
                                        <p class="font-bold text-primary text-lg">
                                            Rp{{ number_format($event->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="flex items-center gap-3">
                                    <i class="fa-regular fa-calendar text-primary text-lg"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Tanggal Acara</p>
                                        <p class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}</p>
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-location-dot text-primary text-lg"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Lokasi</p>
                                        <p class="font-semibold text-gray-900">{{ $event->location }}</p>
                                    </div>
                                </div>

                                <!-- Registration Deadline -->
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-clock text-primary text-lg"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Batas Pendaftaran</p>
                                        <p class="font-semibold text-gray-900">
                                            {{ \Carbon\Carbon::parse($event->regist_end_date)->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="divider my-2"></div>

                            <!-- Important Note -->
                            <div class="alert alert-info">
                                <i class="fa-solid fa-circle-info"></i>
                                <div class="text-sm">
                                    <p class="font-semibold mb-1">Informasi Penting:</p>
                                    <p>Pastikan data yang Anda masukkan sudah benar dan lengkap sebelum mendaftar.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Registration Form Card -->
            <div class="w-full">
                <div class="card bg-white shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-2xl text-gray-900 mb-2">
                            <i class="fa-solid fa-pen-to-square text-primary"></i>
                            Form Pendaftaran
                        </h2>
                        <p class="text-gray-600 mb-6">Lengkapi form di bawah ini untuk mendaftar event</p>
                        <form action="{{ route('landing.events.register', $event->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Event ID (Hidden) -->
                            <input type="hidden" name="event_id" value="{{ $event->id }}">

                            <!-- Member ID (Hidden) -->
                            @if (Auth::check())
                                <input type="hidden" name="member_id" value="{{ Auth::user()->member->id }}">
                            @endif

                            <!-- Nama Lengkap -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">
                                        Nama Lengkap <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="text" name="name" placeholder="Masukkan nama lengkap"
                                    class="input input-bordered w-full @error('name') input-error @enderror"
                                    value="{{ old('name', Auth::user()->name ?? '') }}" required>
                                @error('name')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">
                                        Email <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="email" name="email" placeholder="contoh@email.com"
                                    class="input input-bordered w-full @error('email') input-error @enderror"
                                    value="{{ old('email', Auth::user()->email ?? '') }}" required>
                                @error('email')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- NIM -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">
                                        NIM <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="text" name="nim" placeholder="Masukkan NIM"
                                    class="input input-bordered w-full @error('nim') input-error @enderror"
                                    value="{{ old('nim', Auth::user()->member->nim ?? '') }}" required>
                                @error('nim')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">
                                        Nomor Telepon <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="tel" name="phone" placeholder="08xxxxxxxxxx"
                                    class="input input-bordered w-full @error('phone') input-error @enderror"
                                    value="{{ old('phone', Auth::user()->member->telephone_number ?? '') }}" required>
                                @error('phone')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Bukti Pembayaran -->
                            <div class="form-control mb-6">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">
                                        Bukti Pembayaran <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="file" name="payment_proof" accept="image/*,.pdf"
                                    class="file-input file-input-bordered w-full @error('payment_proof') file-input-error @enderror"
                                    required>
                                <label class="label">
                                    <span class="label-text-alt text-gray-600">
                                        <i class="fa-solid fa-circle-info mr-1"></i>
                                        Format: JPG, PNG, atau PDF (Max. 2MB)
                                    </span>
                                </label>
                                @error('payment_proof')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- KTP/KTM -->
                            <div class="form-control mb-6">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">
                                        KTP/KTM <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="file" name="ktp_ktm" accept="image/*,.pdf"
                                    class="file-input file-input-bordered w-full @error('ktp_ktm') file-input-error @enderror"
                                    required>
                                <label class="label">
                                    <span class="label-text-alt text-gray-600">
                                        <i class="fa-solid fa-circle-info mr-1"></i>
                                        Format: JPG, PNG, atau PDF (Max. 2MB)
                                    </span>
                                </label>
                                @error('ktp_ktm')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Asal Instansi -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">
                                        Asal Instansi <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="text" name="asal_instansi" placeholder="Masukan Asal Instansi"
                                    class="input input-bordered w-full @error('asal_instansi') input-error @enderror"
                                    value="{{ old('asal_instansi', Auth::user()->member->asal_instansi ?? '') }}" required>
                                <label class="label">
                                    <span class="label-text-alt text-gray-600">
                                        <i class="fa-solid fa-circle-info mr-1"></i>
                                        SMA/SMK, KAMPUS, UMUM
                                    </span>
                                </label>
                                @error('asal_instansi')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Payment Instructions -->
                            <div class="alert alert-warning mb-6">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div class="text-sm">
                                    <p class="font-semibold mb-1">Petunjuk Pembayaran:</p>
                                    <p>Transfer ke rekening: <strong>BRI 036801090268503 a.n. Ida
                                            Ayu Ika Pramesti Kesuma</strong></p>
                                    <p>Upload bukti transfer setelah melakukan pembayaran.</p>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="submit" class="btn btn-primary text-white flex-1">
                                    <i class="fa-solid fa-paper-plane mr-2"></i>
                                    Daftar Event
                                </button>
                                <a href="{{ route('landing.events.detail', $event->id) }}"
                                    class="btn btn-outline btn-primary flex-1">
                                    <i class="fa-solid fa-arrow-left mr-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
