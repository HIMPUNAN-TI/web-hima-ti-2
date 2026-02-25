@extends('layouts.admin_layout')

@section('page-title')
    Edit Pengguna
@endsection

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <form class="card" method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h3 class="card-title">Formulir Edit Pengguna (Users)</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Nama</label>
                            <div>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Nama pengguna"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Email</label>
                            <div>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="email@domain.com"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (opsional)</label>
                            <div>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Isi untuk mengganti password">
                                <small class="form-hint">Biarkan kosong jika tidak ingin mengubah.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Role</label>
                            <div>
                                <select name="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>
                                        Member</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
