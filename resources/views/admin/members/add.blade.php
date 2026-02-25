@extends('layouts.admin_layout')

@section('page-title')
    Tambah Member
@endsection

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <form class="card" method="POST" action="{{ route('members.store') }}">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Formulir Tambah Member</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nama</label>
                                    <div>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Nama lengkap" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Email</label>
                                    <div>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="email@domain.com" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">NIM</label>
                                    <div>
                                        <input type="text" name="nim"
                                            class="form-control @error('nim') is-invalid @enderror"
                                            placeholder="Nomor Induk Mahasiswa" value="{{ old('nim') }}">
                                        @error('nim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nomor Telepon</label>
                                    <div>
                                        <input type="text" name="telephone_number"
                                            class="form-control @error('telephone_number') is-invalid @enderror"
                                            placeholder="08xxxxxxxxxx" value="{{ old('telephone_number') }}">
                                        @error('telephone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Program Studi</label>
                                    <div>
                                        <select name="prodi" class="form-select @error('prodi') is-invalid @enderror">
                                            <option value="">Pilih Program Studi</option>
                                            <option value="Teknik Informatika"
                                                {{ old('prodi') === 'Teknik Informatika' ? 'selected' : '' }}>Teknik
                                                Informatika</option>
                                            <option value="Sistem Informasi"
                                                {{ old('prodi') === 'Sistem Informasi' ? 'selected' : '' }}>Sistem
                                                Informasi</option>
                                            <option value="Teknologi Informasi"
                                                {{ old('prodi') === 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi
                                                Informasi</option>
                                            <option value="Sistem Komputer"
                                                {{ old('prodi') === 'Sistem Komputer' ? 'selected' : '' }}>Sistem Komputer
                                            </option>
                                        </select>
                                        @error('prodi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Angkatan</label>
                                    <div>
                                        <select name="generation"
                                            class="form-select @error('generation') is-invalid @enderror">
                                            <option value="">Pilih Angkatan</option>
                                            @for ($year = date('Y'); $year >= 2015; $year--)
                                                <option value="{{ $year }}"
                                                    {{ old('generation') == $year ? 'selected' : '' }}>{{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('generation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password (opsional)</label>
                            <div>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Isi untuk set password">
                                <small class="form-hint">Kosongkan untuk menggunakan default 12345678.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('members.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Show success/error messages
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush
