@extends('layouts.admin_layout')

@section('page-title')
    Manajemen Pembayaran
@endsection

@section('content')
    <div class="container-xl">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Pembayaran</h3>
                <div class="d-flex gap-2">
                    <div>
                        <label for="filterEvent" class="form-label mb-0 me-2">Event</label>
                        <select id="filterEvent" class="form-select form-select-sm d-inline-block" style="min-width: 220px;">
                            <option value="">Semua Event</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->name }}">{{ $event->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="filterStatus" class="form-label mb-0 me-2">Status</label>
                        <select id="filterStatus" class="form-select form-select-sm d-inline-block"
                            style="min-width: 180px;">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="table-default" class="table-responsive">
                    <table id="paymentsTable" class="table card-table table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <th>Event Yang Diikuti</th>
                                <th>Status</th>
                                <th>Alasan (jika ditolak)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->name }}</td>
                                    <td>{{ $payment->event->name }}</td>
                                    <td>
                                        @switch($payment->status)
                                            @case('pending')
                                                <span class="badge text-white bg-warning">Pending</span>
                                            @break

                                            @case('proses cek')
                                                <span class="badge text-white bg-info">Proses Cek</span>
                                            @break

                                            @case('valid')
                                                <span class="badge text-white bg-success">Valid</span>
                                            @break

                                            @case('ditolak')
                                                <span class="badge text-white bg-danger">Ditolak</span>
                                            @break

                                            @default
                                                <span class="badge text-white bg-secondary">{{ $payment->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $payment->decline_reason ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-primary btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                <path
                                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                            </svg>
                                            Detail
                                        </a>
                                        @if($payment->proof_of_payment)
                                        <a href="{{ asset('image/proof_of_payments/' . $payment->proof_of_payment) }}" download="{{ 'Bukti_Pembayaran_' . $payment->name . '_' . $payment->id . '.' . pathinfo($payment->proof_of_payment, PATHINFO_EXTENSION) }}" class="btn btn-info btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                <path d="M12 17v-6"></path>
                                                <path d="M9.5 14.5l2.5 2.5l2.5 -2.5"></path>
                                            </svg>
                                            Bukti
                                        </a>
                                        @endif
                                        <button type="button" class="btn btn-danger btn-sm delete-payment"
                                            data-payment-id="{{ $payment->id }}" data-member-name="{{ $payment->name }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-trash" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 7l16 0"></path>
                                                <path d="M10 11l0 6"></path>
                                                <path d="M14 11l0 6"></path>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                    {{-- Biarkan DataTables menampilkan pesan tabel kosong --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        @push('scripts')
            <script>
                $(document).ready(function() {
                    // Initialize DataTable
                    const table = $('#paymentsTable').DataTable({
                        responsive: true,
                        pageLength: 10,
                        lengthMenu: [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, "Semua"]
                        ],
                        language: {
                            "emptyTable": "Tidak ada data pembayaran",
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
                            targets: [4] // Disable sorting for action column
                        }],
                        order: [
                            [0, 'asc']
                        ]
                    });

                    // Filters
                    $('#filterEvent').on('change', function() {
                        const value = $(this).val();
                        if (value) {
                            table.column(1).search('^' + $.fn.dataTable.util.escapeRegex(value) + '$', true, false)
                                .draw();
                        } else {
                            table.column(1).search('').draw();
                        }
                    });

                    $('#filterStatus').on('change', function() {
                        const value = $(this).val();
                        if (value) {
                            table.column(2).search('^' + $.fn.dataTable.util.escapeRegex(value) + '$', true, false)
                                .draw();
                        } else {
                            table.column(2).search('').draw();
                        }
                    });
                    $(document).on('click', '.delete-payment', function() {
                        const paymentId = $(this).data('payment-id');
                        const memberName = $(this).data('member-name');

                        Swal.fire({
                            title: 'Konfirmasi Hapus',
                            text: `Apakah Anda yakin ingin menghapus pembayaran dari "${memberName}"?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = $('<form>', {
                                    method: 'POST',
                                    action: `{{ route('payments.index') }}/${paymentId}`
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

                                form.appendTo('body').submit();
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
    @endsection
