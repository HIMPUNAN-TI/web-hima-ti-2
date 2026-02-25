@extends('layouts.admin_layout')

@section('page-title')
    Detail Pembayaran
@endsection

@section('content')
    <div class="container-xl">
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Detail Pembayaran
                    </h2>
                </div>
                <div class="col-auto ms-auto">
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Informasi Member</h3>
                                    <p><strong>Nama:</strong> {{ $payment->name }}</p>
                                    <p><strong>NIM:</strong> {{ $payment->nim }}</p>
                                    <p><strong>Email:</strong> {{ $payment->email }}</p>
                                    <p><strong>Nomor Telepon:</strong> {{ $payment->telephone_number }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h3>Informasi Event</h3>
                                    <p><strong>Nama Event:</strong> {{ $payment->event->name }}</p>
                                    <p><strong>Lokasi:</strong> {{ $payment->event->location }}</p>
                                    <p><strong>Tanggal:</strong> {{ $payment->event->date }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                {{-- Proof of Payment Display & Upload --}}
                                <h3>Bukti Pembayaran</h3>
                                <div class="mb-3">
                                    @if ($payment->proof_of_payment)
                                        <div class="mb-2">
                                            @if (Str::of($payment->proof_of_payment)->lower()->endsWith(['.pdf']))
                                                <a href="{{ asset('image/proof_of_payments/' . $payment->proof_of_payment) }}"
                                                    target="_blank" class="btn btn-outline-primary btn-sm">Lihat PDF</a>
                                            @else
                                                <img src="{{ asset('image/proof_of_payments/' . $payment->proof_of_payment) }}"
                                                    alt="Bukti Pembayaran" class="img-fluid rounded border"
                                                    style="max-height: 320px;">
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-muted">Belum ada bukti pembayaran.</p>
                                    @endif
                                </div>

                                <h3>Status Pembayaran</h3>
                                <form action="{{ route('payments.update', $payment) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- <div class="mb-3">
                                        <label class="form-label">Upload Bukti Pembayaran (jpg, png, webp, pdf, maks
                                            4MB)</label>
                                        <input type="file" name="proof_of_payment"
                                            class="form-control @error('proof_of_payment') is-invalid @enderror"
                                            accept=".jpg,.jpeg,.png,.webp,.pdf">
                                        @error('proof_of_payment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="proses cek"
                                                {{ $payment->status == 'proses cek' ? 'selected' : '' }}>Proses Cek
                                            </option>
                                            <option value="valid" {{ $payment->status == 'valid' ? 'selected' : '' }}>
                                                Valid</option>
                                            <option value="ditolak" {{ $payment->status == 'ditolak' ? 'selected' : '' }}>
                                                Ditolak</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id="reasonSection" class="mb-3" style="display: none;">
                                        <label class="form-label">Alasan Penolakan</label>
                                        <select name="decline_reason" id="declineReason"
                                            class="form-select @error('decline_reason') is-invalid @enderror">
                                            <option value="">Pilih Alasan</option>
                                            @foreach ($declineReasons as $reason)
                                                <option value="{{ $reason }}"
                                                    {{ $payment->decline_reason == $reason ? 'selected' : '' }}>
                                                    {{ $reason }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('decline_reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id="customReasonSection" class="mb-3" style="display: none;">
                                        <label class="form-label">Alasan Lainnya</label>
                                        <textarea name="custom_reason" class="form-control @error('custom_reason') is-invalid @enderror" rows="3">{{ old('custom_reason', $payment->decline_reason) }}</textarea>
                                        @error('custom_reason')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                function updateReasonVisibility() {
                    const status = $('#status').val();
                    const reason = $('#declineReason').val();

                    if (status === 'ditolak') {
                        $('#reasonSection').show();
                        if (reason === 'Lainnya') {
                            $('#customReasonSection').show();
                        } else {
                            $('#customReasonSection').hide();
                        }
                    } else {
                        $('#reasonSection').hide();
                        $('#customReasonSection').hide();
                    }
                }

                $('#status').change(updateReasonVisibility);
                $('#declineReason').change(updateReasonVisibility);

                // Initial state
                updateReasonVisibility();
            });
        </script>
    @endpush
@endsection
