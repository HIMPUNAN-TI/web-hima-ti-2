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
                        <li>Kontak</li>
                    </ul>
                </div>
                <h1 class="text-5xl font-bold text-white">Kontak</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{-- ============================= Contact Section ============================= --}}
    <section class="bg-base-200 px-8 md:px-16 lg:px-32 py-16 lg:py-24">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Kontak Kami</h2>
            <div class="w-16 h-1 bg-primary mx-auto mt-3"></div>
            <p class="mt-6 text-base text-gray-600">
                Jangan segan untuk menghubungi kami jika perlu bantuan terkait event dan informasi lainnya terkait Himaprodi
                ITB Stikom Bali
            </p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success shadow-lg mb-6 max-w-4xl mx-auto">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Contact Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
            <!-- Address Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div
                    class="w-16 h-16 rounded-full border-2 border-dashed border-primary flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-location-dot text-primary text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-3">Alamat Kami</h3>
                <p class="text-sm text-gray-600">Jl. Raya Puputan No.86, Dangin Puri Klod</p>
            </div>

            <!-- WhatsApp Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div
                    class="w-16 h-16 rounded-full border-2 border-dashed border-primary flex items-center justify-center mx-auto mb-4">
                    <i class="fa-brands fa-whatsapp text-primary text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-3">Whatsapp Kami</h3>
                <p class="text-sm text-gray-600">+628563735581</p>
            </div>

            <!-- Email Card -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div
                    class="w-16 h-16 rounded-full border-2 border-dashed border-primary flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-envelope text-primary text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-3">Email Kami</h3>
                <p class="text-sm text-gray-600">info@himaproditi.ac.id</p>
            </div>
        </div>

        <!-- Contact Form and Map -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Map -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden h-[500px]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.0524347347257!2d115.22639831478285!3d-8.682586193758877!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2409b0e5e80db%3A0xe27334e8ccb9b21a!2sInstitut%20Teknologi%20Dan%20Bisnis%20STIKOM%20Bali!5e0!3m2!1sen!2sid!4v1635000000000!5m2!1sen!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-sm p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Punya Pertanyaan?</h2>
                <p class="text-sm text-gray-600 mb-6">Silahkan ajukan pertanyaan anda pada kami jika ada pertanyaan terkait
                    event dan informasi
                    lainnya terkait Himaprodi TI ITB Stikom Bali</p>
                <form action="{{ route('landing.contact.submit') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <input type="text" name="name" placeholder="Nama Lengkap"
                                class="input input-bordered w-full bg-gray-50 focus:bg-white @error('name') input-error @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <input type="email" name="email" placeholder="Email"
                                class="input input-bordered w-full bg-gray-50 focus:bg-white @error('email') input-error @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-error text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="subject" placeholder="Subjek"
                            class="input input-bordered w-full bg-gray-50 focus:bg-white @error('subject') input-error @enderror"
                            value="{{ old('subject') }}" required>
                        @error('subject')
                            <span class="text-error text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <textarea name="message" placeholder="Pesan" rows="8"
                            class="textarea textarea-bordered w-full bg-gray-50 focus:bg-white resize-none @error('message') textarea-error @enderror"
                            required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-error text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block px-10 text-white">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    {{-- ============================= End Contact Section ============================= --}}
@endsection
