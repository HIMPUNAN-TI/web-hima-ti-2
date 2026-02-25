@extends('layouts.admin_layout')

@section('page-title')
    Detail Event
@endsection

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title h2">{{ $event->name }}</h3>
                        <div class="btn-list">
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                    <path d="M16 5l3 3"></path>
                                </svg>
                                Edit
                            </a>
                            <a href="{{ route('events.index') }}" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l14 0"></path>
                                    <path d="M5 12l6 6"></path>
                                    <path d="M5 12l6 -6"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    @php
                                        $now = now();
                                        $registStart = $event->regist_start_date;
                                        $registEnd = $event->regist_end_date;
                                        $eventDate = $event->date;

                                        if ($now < $registStart) {
                                            $status = 'Segera Dibuka';
                                            $statusClass = 'bg-yellow';
                                        } elseif ($now >= $registStart && $now <= $registEnd) {
                                            $status = 'Pendaftaran Dibuka';
                                            $statusClass = 'bg-green';
                                        } elseif ($now > $registEnd && $now < $eventDate) {
                                            $status = 'Pendaftaran Ditutup';
                                            $statusClass = 'bg-orange';
                                        } else {
                                            $status = 'Event Selesai';
                                            $statusClass = 'bg-red';
                                        }
                                    @endphp
                                    <span class="badge text-white {{ $statusClass }} fs-3">{{ $status }}</span>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Harga:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        <span class="text-primary fs-2 fw-bold">
                                            @if ($event->price > 0)
                                                Rp {{ number_format($event->price, 0, ',', '.') }}
                                            @else
                                                Gratis
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Tanggal Event:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $event->date->format('l, d F Y') }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Lokasi:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $event->location }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Periode Registrasi:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $event->regist_start_date->format('d M Y') }} -
                                        {{ $event->regist_end_date->format('d M Y') }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Deskripsi:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        <div style="white-space: pre-line;">{!! $event->description !!}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Dibuat:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $event->created_at->format('d M Y H:i') }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Terakhir Diperbarui:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $event->updated_at->format('d M Y H:i') }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Link Maps:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        <a href="{{ $event->maps }}" target="_blank">{{ $event->maps }}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                @if ($event->poster)
                                    <div class="mb-4">
                                        <h4>Poster Event</h4>
                                        <img src="{{ $event->poster_url }}" alt="{{ $event->name }} Poster"
                                            class="img-fluid rounded shadow-sm"
                                            style="max-height: 300px; width: 100%; object-fit: cover;">
                                        <div class="mt-2">
                                            <a href="{{ $event->poster_url }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-external-link" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6">
                                                    </path>
                                                    <path d="M11 13l9 -9"></path>
                                                    <path d="M15 4h5v5"></path>
                                                </svg>
                                                Lihat Full Size
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if ($event->certificate)
                                    <div class="mb-4">
                                        <h4>Template Sertifikat</h4>
                                        <img src="{{ $event->certificate_url }}" alt="{{ $event->name }} Certificate"
                                            class="img-fluid rounded shadow-sm"
                                            style="max-height: 300px; width: 100%; object-fit: cover;">
                                        <div class="mt-2">
                                            <a href="{{ $event->certificate_url }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-external-link" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6">
                                                    </path>
                                                    <path d="M11 13l9 -9"></path>
                                                    <path d="M15 4h5v5"></path>
                                                </svg>
                                                Lihat Full Size
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if (!$event->poster && !$event->certificate)
                                    <div class="empty">
                                        <div class="empty-img">
                                            <img src="{{ asset('tabler/static/illustrations/undraw_bug_fixing_oc7a.svg') }}"
                                                height="128" alt="">
                                        </div>
                                        <p class="empty-title">Tidak ada gambar</p>
                                        <p class="empty-subtitle text-secondary">
                                            Poster dan sertifikat belum diupload
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
