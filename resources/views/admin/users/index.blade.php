@extends('layouts.admin_layout')

@push('styles')
    <style>
        .dataTables_length {
            padding-left: 20px;
            padding-top: 20px
        }

        .dataTables_filter {
            padding-right: 20px;
            padding-top: 20px;
        }

        .dataTables_info {
            padding-left: 20px;
            padding-top: 20px;
        }

        .dataTables_paginate {
            padding-right: 20px;
            padding-top: 6px;
        }
    </style>
@endpush

@section('page-title')
    Manajemen Pengguna
@endsection

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Pengguna (Users)</h3>
                        <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>
                    </div>
                    <div class="table-responsive">
                        <table id="usersTable" class="table card-table table-vcenter text-nowrap">
                            <thead>
                                <tr>
                                    <th class="w-1">#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Password</th>
                                    <th>Dibuat</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td><span class="text-secondary">{{ $loop->iteration }}</span></td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span
                                                class="badge text-white {{ $user->role === 'admin' ? 'bg-blue' : 'bg-green' }}">{{ ucfirst($user->role) }}</span>
                                        </td>
                                        <td>{{ $user->password }}</td>
                                        <td>{{ $user->created_at?->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <div class="btn-list">
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-edit" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                        </path>
                                                        <path
                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                        </path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <button type="button" class="btn btn-danger delete-user"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->name }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-trash" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 7l16 0"></path>
                                                        <path d="M10 11l0 6"></path>
                                                        <path d="M14 11l0 6"></path>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#usersTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Semua"]
                ],
                language: {
                    "sProcessing": "Sedang memproses...",
                    "sLengthMenu": "Tampilkan _MENU_ entri",
                    "sZeroRecords": "Tidak ditemukan data yang sesuai",
                    "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                    "sInfoPostFix": "",
                    "sSearch": "Cari:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sPrevious": "Sebelumnya",
                        "sNext": "Selanjutnya",
                        "sLast": "Terakhir"
                    }
                },
                columnDefs: [{
                        orderable: false,
                        targets: [6]
                    } // Disable sorting for action column
                ],
                order: [
                    [0, 'asc']
                ] // Default sort by ID
            });

            // Handle delete button click
            $(document).on('click', '.delete-user', function() {
                const userId = $(this).data('user-id');
                const userName = $(this).data('user-name');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus user "${userName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create and submit form
                        const form = $('<form>', {
                            method: 'POST',
                            action: `{{ route('users.index') }}/${userId}`
                        });

                        form.append($('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: '{{ csrf_token() }}'
                        }));

                        form.append($('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        }));

                        $('body').append(form);
                        form.submit();
                    }
                });
            });

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
