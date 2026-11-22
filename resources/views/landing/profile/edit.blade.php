@extends('layouts.landing_layout')

@section('page-title')
    <section class="hero min-h-[35vh] mt-[73px] justify-items-start"
        style="background-image: url({{ asset('image/landing/dash5.png') }});">
        <div class="hero-overlay bg-[rgba(1,64,151,0.75)]"></div>

        <div class="hero-content text-neutral-content text-center px-8 md:px-16 lg:px-32">
            <div class="max-w-4xl">
                <div class="breadcrumbs text-sm">
                    <ul>
                        <li><a href="{{ route('landing.index') }}">Beranda</a></li>
                        <li>Profil Peserta</li>
                    </ul>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white">Profil Peserta</h1>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="bg-gray-50 px-6 md:px-16 lg:px-32 py-12 lg:py-16">
        <div class="max-w-3xl mx-auto">

            @if (session('warning'))
                <div class="alert alert-warning mb-6 shadow-md rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mb-6 shadow-md text-white rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="card bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                <div class="card-body p-8 sm:p-10">

                    <!-- Avatar & Info Awal -->
                    <div class="flex flex-col sm:flex-row items-center gap-5 pb-6 border-b border-gray-100">
                        <div class="avatar">
                            <div class="w-20 h-20 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2 overflow-hidden bg-primary/10 flex items-center justify-center">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" />
                                @else
                                    <span class="text-3xl font-bold text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-center sm:text-left">
                            <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-gray-500 text-sm mt-1 flex items-center justify-center sm:justify-start gap-2">
                                <span>{{ $user->email }}</span>
                                @if ($user->email_verified_at)
                                    <span class="badge badge-success badge-sm text-white">Terverifikasi</span>
                                @endif
                            </p>
                            <p class="text-xs text-primary font-medium mt-2">
                                * Data wajib lengkap sebelum mendaftar ke kegiatan atau event.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('landing.profile.update') }}" method="POST" class="mt-6 space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Nama Lengkap -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-gray-700">Nama Lengkap <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="name"
                                class="input input-bordered w-full rounded-xl @error('name') input-error @enderror"
                                value="{{ old('name', $user->name) }}" required placeholder="Contoh: I Gede Adyatmaputra">
                            @error('name')
                                <span class="text-error text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email (Readonly) -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-gray-700">Alamat Email</span>
                            </label>
                            <input type="email" value="{{ $user->email }}" readonly disabled
                                class="input input-bordered w-full rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed">
                            <span class="text-xs text-gray-400 mt-1">Email terkait akun dan tidak dapat diubah sembarangan.</span>
                        </div>

                        <!-- Nomor HP / WhatsApp -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-gray-700">Nomor HP / WhatsApp <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="telephone_number"
                                class="input input-bordered w-full rounded-xl @error('telephone_number') input-error @enderror"
                                value="{{ old('telephone_number', $member->telephone_number) }}" required
                                placeholder="Contoh: 081234567890">
                            @error('telephone_number')
                                <span class="text-error text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Asal Institusi / Kampus / Sekolah / Umum -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-gray-700">Asal Institusi / Kampus / Sekolah <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="institution"
                                class="input input-bordered w-full rounded-xl @error('institution') input-error @enderror"
                                value="{{ old('institution', $member->institution) }}" required
                                placeholder="Contoh: ITB STIKOM Bali / SMA Negeri 1 / Umum">
                            @error('institution')
                                <span class="text-error text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Grid: NIM (Opsional) & Program Studi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- NIM -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">NIM (Nomor Induk Mahasiswa)</span>
                                    <span class="label-text-alt text-gray-400 text-xs">Opsional jika ada</span>
                                </label>
                                <input type="text" name="nim"
                                    class="input input-bordered w-full rounded-xl @error('nim') input-error @enderror"
                                    value="{{ old('nim', $member->nim) }}"
                                    placeholder="Contoh: 230010001">
                                @error('nim')
                                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Program Studi -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-700">Program Studi / Jurusan</span>
                                    <span class="label-text-alt text-gray-400 text-xs">Opsional</span>
                                </label>
                                <input type="text" name="prodi"
                                    class="input input-bordered w-full rounded-xl @error('prodi') input-error @enderror"
                                    value="{{ old('prodi', $member->prodi) }}"
                                    placeholder="Contoh: Teknologi Informasi">
                                @error('prodi')
                                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Angkatan -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-gray-700">Tahun Angkatan</span>
                                <span class="label-text-alt text-gray-400 text-xs">Opsional</span>
                            </label>
                            <input type="text" name="generation"
                                class="input input-bordered w-full rounded-xl @error('generation') input-error @enderror"
                                value="{{ old('generation', $member->generation) }}"
                                placeholder="Contoh: 2023">
                            @error('generation')
                                <span class="text-error text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="pt-4 flex items-center justify-end gap-3">
                            <a href="{{ route('landing.index') }}" class="btn btn-ghost rounded-xl">Batal</a>
                            <button type="submit" class="btn btn-primary px-8 rounded-xl text-white shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Profil
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
