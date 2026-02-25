@extends('layouts.admin_layout')

@section('page-title')
    Dashboard Admin
@endsection

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="row row-cards">
                    <!-- Card Total Members -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-primary text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $totalMembers }} Members
                                        </div>
                                        <div class="text-secondary">
                                            Total registered members
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Events -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <rect x="4" y="5" width="16" height="16" rx="2" />
                                                <line x1="16" y1="3" x2="16" y2="7" />
                                                <line x1="8" y1="3" x2="8" y2="7" />
                                                <line x1="4" y1="11" x2="20" y2="11" />
                                                <rect x="8" y="15" width="2" height="2" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $totalEvents }} Events
                                        </div>
                                        <div class="text-secondary">
                                            Total events created
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total Payments -->
                    <div class="col-sm-6 col-lg-4">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-yellow text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                                <path d="M12 3v3m0 12v3" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            {{ $totalPayments }} Payments
                                        </div>
                                        <div class="text-secondary">
                                            {{ $pendingPayments }} pending payments
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inbox Section -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Messages from Contacts</h3>
                    </div>
                    <div class="card-body p-0">
                        @if ($contacts->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($contacts as $contact)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="avatar">{{ strtoupper(substr($contact->name, 0, 2)) }}</span>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div>
                                                        <strong>{{ $contact->name }}</strong>
                                                        <span class="text-muted ms-2">{{ $contact->email }}</span>
                                                        @if ($contact->phone)
                                                            <span class="text-muted ms-2">• {{ $contact->phone }}</span>
                                                        @endif
                                                    </div>
                                                    <small
                                                        class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                                                </div>
                                                @if ($contact->subject)
                                                    <div class="text-primary mb-1">
                                                        <strong>Subject:</strong> {{ $contact->subject }}
                                                    </div>
                                                @endif
                                                <div class="text-secondary">
                                                    {{ Str::limit($contact->message, 150) }}
                                                </div>
                                                @if ($contact->status)
                                                    <div class="mt-2">
                                                        @if ($contact->status == 'new')
                                                            <span class="badge bg-blue">New</span>
                                                        @elseif($contact->status == 'read')
                                                            <span class="badge bg-green">Read</span>
                                                        @elseif($contact->status == 'replied')
                                                            <span class="badge bg-success">Replied</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="3" y="5" width="18" height="14" rx="2" />
                                        <polyline points="3 7 12 13 21 7" />
                                    </svg>
                                </div>
                                <p class="empty-title">No messages yet</p>
                                <p class="empty-subtitle text-muted">
                                    You don't have any contact messages at the moment.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
