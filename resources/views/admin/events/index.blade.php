@extends('layouts.admin_layout')

@push('styles')
    <style>
        .event-card {
            transition: transform 0.2s ease-in-out;
            height: 100%;
        }

        .event-card:hover {
            transform: translateY(-5px);
        }

        .event-poster {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .event-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #206bc4;
        }

        .event-date {
            background: #206bc4;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        .event-status {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }

        /* Styling Tombol Aksi Baru - Lebih Kontras & Jelas */
        .card-actions {
            position: absolute;
            top: 14px;
            /* left: 5px; */
            z-index: 10;
        }

        .btn-action-custom {
            background: rgba(255, 255, 255, 0.3); /* Putih semi-transparan */
            backdrop-filter: blur(8px); /* Efek kaca */
            -webkit-backdrop-filter: blur(8px);
            color: #1d273b;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            text-decoration: none !important;
        }

        .btn-action-custom:hover {
            background: rgba(255, 255, 255, 1);
            color: #206bc4;
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .event-description {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@section('page-title')
    Manajemen Event
@endsection

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4 w-full">
                    <h2 class="page-title">Daftar Event</h2>
                    <a href="{{ route('events.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah Event
                    </a>
                </div>
            </div>

            <!-- Search Input -->
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                            </span>
                            <input type="text" id="eventSearch" class="form-control"
                                placeholder="Cari nama event, lokasi, atau deskripsi...">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x"
                                    width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M18 6l-12 12"></path>
                                    <path d="M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <select id="statusFilter" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="upcoming">Segera Dibuka</option>
                                <option value="open">Pendaftaran Dibuka</option>
                                <option value="closed">Pendaftaran Ditutup</option>
                                <option value="finished">Event Selesai</option>
                            </select>
                            <select id="priceFilter" class="form-select">
                                <option value="">Semua Harga</option>
                                <option value="free">Gratis</option>
                                <option value="paid">Berbayar</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Info -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center w-full">
                    <div>
                        <span id="resultsInfo" class="text-muted">
                            @if (!$events->isEmpty())
                                Menampilkan {{ $events->count() }} event
                            @endif
                        </span>
                    </div>
                    <div>
                        <button class="btn btn-outline-secondary btn-sm" id="resetFilters" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh"
                                width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                            </svg>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>

            @if ($events->isEmpty())
                <div class="col-12 justify-content-center w-full">
                    <div class="empty">
                        <p class="empty-title">Belum ada event</p>
                        <p class="empty-subtitle text-secondary">
                            Mulai dengan membuat event pertama Anda
                        </p>
                        <div class="empty-action">
                            <a href="{{ route('events.create') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Tambah Event
                            </a>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($events->chunk(4) as $eventChunk)
                    @foreach ($eventChunk as $event)
                        <div class="col-sm-6 col-lg-3">
                            <div class="card event-card position-relative">
                                <div class="card-actions">
                                    <div class="dropdown">
                                        <a href="#" class="btn-action-custom" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                <path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                                <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('events.show', $event) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                                                    </path>
                                                </svg>
                                                Lihat Detail
                                            </a>
                                            <a class="dropdown-item" href="{{ route('events.edit', $event) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                    </path>
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                    </path>
                                                    <path d="M16 5l3 3"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <button type="button" class="dropdown-item text-danger delete-event"
                                                data-event-id="{{ $event->id }}" data-event-name="{{ $event->name }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon"
                                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
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
                                    </div>
                                </div>

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

                                <div class="event-status">
                                    <span class="badge text-white {{ $statusClass }}">{{ $status }}</span>
                                </div>

                                @if ($event->poster)
                                    <img src="{{ $event->poster_url }}" alt="{{ $event->name }}"
                                        class="card-img-top event-poster">
                                @else
                                    <div
                                        class="card-img-top event-poster bg-light d-flex align-items-center justify-content-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo"
                                            width="48" height="48" viewBox="0 0 24 24" stroke-width="1"
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

                                <div class="card-body">
                                    <h3 class="card-title">{{ $event->name }}</h3>

                                    <div class="mb-2">
                                        <span class="event-price">
                                            @if ($event->price > 0)
                                                Rp {{ number_format($event->price, 0, ',', '.') }}
                                            @else
                                                Gratis
                                            @endif
                                        </span>
                                    </div>

                                    <div class="mb-2">
                                        <small class="text-muted d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-calendar me-1" width="16"
                                                height="16" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z">
                                                </path>
                                                <path d="M16 3v4"></path>
                                                <path d="M8 3v4"></path>
                                                <path d="M4 11h16"></path>
                                            </svg>
                                            {{ $event->date->format('d M Y') }}
                                        </small>
                                    </div>

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
                                            {{ Str::limit($event->location, 30) }}
                                        </small>
                                    </div>

                                    <p class="text-secondary event-description">{!! $event->description !!}</p>

                                    <div class="mt-3 text-muted small">
                                        <div>Registrasi: {{ $event->regist_start_date->format('d M') }} -
                                            {{ $event->regist_end_date->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let allEvents = $('.event-card').parent(); // Store all event cards
            let totalEvents = allEvents.length;

            // Search functionality
            function performSearch() {
                const searchTerm = $('#eventSearch').val().toLowerCase();
                const statusFilter = $('#statusFilter').val();
                const priceFilter = $('#priceFilter').val();

                let visibleCount = 0;
                let hasActiveFilters = searchTerm || statusFilter || priceFilter;

                allEvents.each(function() {
                    const $eventCard = $(this);
                    const $card = $eventCard.find('.event-card');

                    // Get event data
                    const eventName = $card.find('.card-title').text().toLowerCase();
                    const eventLocation = $card.find('.icon-tabler-map-pin').parent().text().toLowerCase();
                    const eventDescription = $card.find('.event-description').text().toLowerCase();
                    const eventPrice = $card.find('.event-price').text().toLowerCase();
                    const eventStatus = $card.find('.event-status .badge').text().toLowerCase();

                    // Check search term
                    const matchesSearch = !searchTerm ||
                        eventName.includes(searchTerm) ||
                        eventLocation.includes(searchTerm) ||
                        eventDescription.includes(searchTerm);

                    // Check status filter
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

                    // Check price filter
                    let matchesPrice = !priceFilter;
                    if (priceFilter) {
                        switch (priceFilter) {
                            case 'free':
                                matchesPrice = eventPrice.includes('gratis');
                                break;
                            case 'paid':
                                matchesPrice = !eventPrice.includes('gratis');
                                break;
                        }
                    }

                    // Show/hide event based on all criteria
                    if (matchesSearch && matchesStatus && matchesPrice) {
                        $eventCard.show();
                        visibleCount++;
                    } else {
                        $eventCard.hide();
                    }
                });

                // Update results info
                updateResultsInfo(visibleCount, hasActiveFilters);

                // Show/hide reset button
                $('#resetFilters').toggle(hasActiveFilters);

                // Show/hide empty state
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
                        <div class="col-12 justify-content-center" id="noResultsMessage">
                            <div class="empty">
                                <div class="empty-img">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search-off" width="128" height="128" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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

            // Reset all filters
            window.resetAllFilters = function() {
                $('#eventSearch').val('');
                $('#statusFilter').val('');
                $('#priceFilter').val('');
                performSearch();
            };

            // Event listeners
            $('#eventSearch').on('input', performSearch);
            $('#statusFilter').on('change', performSearch);
            $('#priceFilter').on('change', performSearch);
            $('#resetFilters').on('click', resetAllFilters);

            // Clear search button
            $('#clearSearch').on('click', function() {
                $('#eventSearch').val('');
                performSearch();
            });

            // Handle delete button click
            $(document).on('click', '.delete-event', function() {
                const eventId = $(this).data('event-id');
                const eventName = $(this).data('event-name');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: `Apakah Anda yakin ingin menghapus event "${eventName}"?`,
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
                            action: `{{ route('events.index') }}/${eventId}`
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