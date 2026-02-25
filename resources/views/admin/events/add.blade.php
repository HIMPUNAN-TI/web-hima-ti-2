@extends('layouts.admin_layout')

@section('page-title')
    Tambah Event
@endsection

@push('styles')
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame .note-editing-area .note-editable {
            background-color: #fff;
        }

        .note-popover .popover-content,
        .panel-heading.note-toolbar {
            background-color: #f7f7f7;
        }
    </style>
@endpush

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <form class="card" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Formulir Tambah Event</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Event</label>
                                    <div>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Nama event" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="price" min="0" step="0.01"
                                            class="form-control @error('price') is-invalid @enderror" placeholder="0"
                                            value="{{ old('price', 0) }}">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="form-hint">Masukkan 0 untuk event gratis</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Tanggal Event</label>
                                    <div>
                                        <input type="date" name="date"
                                            class="form-control @error('date') is-invalid @enderror"
                                            value="{{ old('date') }}">
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Mulai Registrasi</label>
                                    <div>
                                        <input type="date" name="regist_start_date"
                                            class="form-control @error('regist_start_date') is-invalid @enderror"
                                            value="{{ old('regist_start_date') }}">
                                        @error('regist_start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Selesai Registrasi</label>
                                    <div>
                                        <input type="date" name="regist_end_date"
                                            class="form-control @error('regist_end_date') is-invalid @enderror"
                                            value="{{ old('regist_end_date') }}">
                                        @error('regist_end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Lokasi</label>
                            <div>
                                <input type="text" name="location"
                                    class="form-control @error('location') is-invalid @enderror" placeholder="Lokasi event"
                                    value="{{ old('location') }}">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Link Maps</label>
                            <div>
                                <input type="url" name="maps"
                                    class="form-control @error('maps') is-invalid @enderror"
                                    placeholder="https://maps.google.com/..." value="{{ old('maps') }}" required>
                                @error('maps')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Deskripsi</label>
                            <div>
                                <textarea id="summernote" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Poster Event</label>
                                    <div>
                                        <input type="file" name="poster" accept="image/*"
                                            class="form-control @error('poster') is-invalid @enderror"
                                            onchange="previewImage(this, 'poster-preview')">
                                        @error('poster')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-hint">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                    </div>
                                    <div class="mt-2">
                                        <img id="poster-preview" src="#" alt="Preview Poster"
                                            style="display: none; max-width: 200px; max-height: 200px; border-radius: 0.375rem;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Template Sertifikat</label>
                                    <div>
                                        <input type="file" name="certificate" accept="image/*"
                                            class="form-control @error('certificate') is-invalid @enderror"
                                            onchange="previewImage(this, 'certificate-preview')">
                                        @error('certificate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-hint">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                    </div>
                                    <div class="mt-2">
                                        <img id="certificate-preview" src="#" alt="Preview Sertifikat"
                                            style="display: none; max-width: 200px; max-height: 200px; border-radius: 0.375rem;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('events.index') }}" class="btn btn-secondary me-2">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        $(document).ready(function() {
            // Initialize Summernote
            $('#summernote').summernote({
                placeholder: 'Tulis deskripsi event di sini...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['forecolor', 'backcolor']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
                dialogsInBody: true,
                disableDragAndDrop: false
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

            // Auto-adjust date constraints
            const eventDate = document.querySelector('input[name="date"]');
            const registStart = document.querySelector('input[name="regist_start_date"]');
            const registEnd = document.querySelector('input[name="regist_end_date"]');

            // Set minimum date to today for all date fields
            const today = new Date().toISOString().split('T')[0];
            eventDate.min = today;
            registStart.min = today;
            registEnd.min = today;

            // Update constraints when dates change
            eventDate.addEventListener('change', function() {
                registEnd.max = this.value;
            });

            registStart.addEventListener('change', function() {
                registEnd.min = this.value;
            });

            registEnd.addEventListener('change', function() {
                registStart.max = this.value;
            });
        });
    </script>
@endpush
