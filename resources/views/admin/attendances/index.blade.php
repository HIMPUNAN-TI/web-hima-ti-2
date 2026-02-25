@extends('layouts.admin_layout')

@push('styles')
    <style>
        .event-card {
            transition: transform 0.2s ease-in-out;
        }

        .event-card:hover {
            transform: translateY(-5px);
        }

        .event-poster {
            height: 150px;
            object-fit: cover;
            width: 100%;
            border-radius: 8px;
        }

        .event-date-badge {
            background: #206bc4;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            display: inline-block;
        }

        .attendance-info {
            font-size: 0.875rem;
        }

        .btn-dashboard {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .btn-list-attendee {
            width: 100%;
        }
    </style>
@endpush

@section('page-title')
    Daftar Absensi Event
@endsection

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <!-- Header Section -->
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="page-title mb-1">Absensi</h2>
                        <p class="text-muted">Kelola daftar kehadiran peserta event</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="btn btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l6 6"></path>
                            <path d="M5 12l6 -6"></path>
                        </svg>
                        Kembali ke Event
                    </a>
                </div>
            </div>

            <!-- Search Section -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                            <path d="M21 21l-6 -6"></path>
                                        </svg>
                                    </span>
                                    <input type="text" id="eventSearch" class="form-control"
                                        placeholder="Cari nama event atau lokasi...">
                                    <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x"
                                            width="20" height="20" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M18 6l-12 12"></path>
                                            <path d="M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select id="statusFilter" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="upcoming">Segera Dibuka</option>
                                    <option value="open">Pendaftaran Dibuka</option>
                                    <option value="closed">Pendaftaran Ditutup</option>
                                    <option value="finished">Event Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Info -->
            <div class="col-12 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span id="resultsInfo" class="text-muted">
                        @if (!$events->isEmpty())
                            Menampilkan {{ $events->count() }} event
                        @endif
                    </span>
                    <button class="btn btn-outline-secondary btn-sm" id="resetFilters" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="16"
                            height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                        </svg>
                        Reset Filter
                    </button>
                </div>
            </div>

            <!-- Event Cards -->
            @if ($events->isEmpty())
                <div class="col-12">
                    <div class="empty">
                        <div class="empty-img">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event"
                                width="128" height="128" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                </path>
                                <path d="M16 3v4"></path>
                                <path d="M8 3v4"></path>
                                <path d="M4 11h16"></path>
                                <path d="M8 15h2v2h-2z"></path>
                            </svg>
                        </div>
                        <p class="empty-title">Belum ada event</p>
                        <p class="empty-subtitle text-secondary">
                            Tidak ada event yang tersedia untuk saat ini
                        </p>
                    </div>
                </div>
            @else
                @foreach ($events as $event)
                    <div class="col-md-6 col-lg-4">
                        <div class="card event-card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Event Poster -->
                                    <div class="col-12">
                                        @if ($event->poster)
                                            <img src="{{ $event->poster_url }}" alt="{{ $event->name }}"
                                                class="event-poster">
                                        @else
                                            <div
                                                class="event-poster bg-light d-flex align-items-center justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-photo text-muted" width="48"
                                                    height="48" viewBox="0 0 24 24" stroke-width="1"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M15 8h.01"></path>
                                                    <path
                                                        d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z">
                                                    </path>
                                                    <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
                                                    <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Event Info -->
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <span class="event-date-badge">
                                                {{ $event->date->format('d M Y') }}
                                            </span>
                                        </div>

                                        <h3 class="card-title mb-2">{{ $event->name }}</h3>

                                        <div class="mb-2">
                                            <small class="text-muted d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-map-pin me-1" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                                    <path
                                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                                                    </path>
                                                </svg>
                                                {{ Str::limit($event->location, 35) }}
                                            </small>
                                        </div>

                                        @php
                                            $totalRegistrations = $event->registrations->count();
                                            $attendedCount = $event->registrations
                                                ->where('attendance_status', 'attended')
                                                ->count();

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

                                        <div class="mb-3">
                                            <span class="badge {{ $statusClass }} text-white">{{ $status }}</span>
                                        </div>

                                        <div class="attendance-info mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="text-muted">Kedatangan Peserta:</span>
                                                <strong>{{ $attendedCount }} / {{ $totalRegistrations }}</strong>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                @php
                                                    $percentage =
                                                        $totalRegistrations > 0
                                                            ? ($attendedCount / $totalRegistrations) * 100
                                                            : 0;
                                                @endphp
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: {{ $percentage }}%"
                                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <a href="#" class="btn btn-primary btn-dashboard">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-layout-dashboard me-1"
                                                        width="20" height="20" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M4 4h6v8h-6z"></path>
                                                        <path d="M4 16h6v4h-6z"></path>
                                                        <path d="M14 12h6v8h-6z"></path>
                                                        <path d="M14 4h6v4h-6z"></path>
                                                    </svg>
                                                    Dashboard Absensi
                                                </a>
                                            </div>
                                            <div class="col-12">
                                                <a href="#" class="btn btn-outline-primary btn-list-attendee">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-users me-1" width="20"
                                                        height="20" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                                    </svg>
                                                    Daftar Absen
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let allEvents = $('.event-card').parent();
            let totalEvents = allEvents.length;

            function performSearch() {
                const searchTerm = $('#eventSearch').val().toLowerCase();
                const statusFilter = $('#statusFilter').val();

                let visibleCount = 0;
                let hasActiveFilters = searchTerm || statusFilter;

                allEvents.each(function() {
                    const $eventCard = $(this);
                    const $card = $eventCard.find('.event-card');

                    const eventName = $card.find('.card-title').text().toLowerCase();
                    const eventLocation = $card.find('.icon-tabler-map-pin').parent().text().toLowerCase();
                    const eventStatus = $card.find('.badge').text().toLowerCase();

                    const matchesSearch = !searchTerm ||
                        eventName.includes(searchTerm) ||
                        eventLocation.includes(searchTerm);

                    let matchesStatus = !statusFilter;
                    if (statusFilter) {
                        switch (statusFilter) {
                            case 'upcoming':
                                matchesStatus = eventStatus.includes('segera dibuka');
                                break;
                            case 'open':
                                matchesStatus = eventStatus.includes('pendaftaran dibuka');
                                break;
                            case 'closed':
                                matchesStatus = eventStatus.includes('pendaftaran ditutup');
                                break;
                            case 'finished':
                                matchesStatus = eventStatus.includes('event selesai');
                                break;
                        }
                    }

                    if (matchesSearch && matchesStatus) {
                        $eventCard.show();
                        visibleCount++;
                    } else {
                        $eventCard.hide();
                    }
                });

                updateResultsInfo(visibleCount, hasActiveFilters);
                $('#resetFilters').toggle(hasActiveFilters);

                if (visibleCount === 0 && hasActiveFilters) {
                    showNoResultsMessage();
                } else {
                    hideNoResultsMessage();
                }
            }

            function updateResultsInfo(count, hasFilters) {
                if (hasFilters) {
                    $('#resultsInfo').text(`Menampilkan ${count} dari ${totalEvents} event`);
                } else {
                    $('#resultsInfo').text(totalEvents > 0 ? `Menampilkan ${totalEvents} event` : '');
                }
            }

            function showNoResultsMessage() {
                if ($('#noResultsMessage').length === 0) {
                    const noResultsHtml = `
                        <div class="col-12" id="noResultsMessage">
                            <div class="empty">
                                <div class="empty-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search-off" 
                                        width="128" height="128" viewBox="0 0 24 24" stroke-width="1" 
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                        <path d="M21 21l-6 -6"></path>
                                        <path d="M3 3l18 18"></path>
                                    </svg>
                                </div>
                                <p class="empty-title">Tidak ada event yang ditemukan</p>
                                <p class="empty-subtitle text-secondary">
                                    Coba ubah kata kunci pencarian atau filter yang digunakan
                                </p>
                                <div class="empty-action">
                                    <button class="btn btn-outline-secondary" onclick="resetAllFilters()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" 
                                            width="16" height="16" viewBox="0 0 24 24" stroke-width="2" 
                                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                        </svg>
                                        Reset Pencarian
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('.row-deck.row-cards').append(noResultsHtml);
                }
            }

            function hideNoResultsMessage() {
                $('#noResultsMessage').remove();
            }

            window.resetAllFilters = function() {
                $('#eventSearch').val('');
                $('#statusFilter').val('');
                performSearch();
            };

            $('#eventSearch').on('input', performSearch);
            $('#statusFilter').on('change', performSearch);
            $('#resetFilters').on('click', resetAllFilters);

            $('#clearSearch').on('click', function() {
                $('#eventSearch').val('');
                performSearch();
            });

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
