@extends('layouts.app')

@section('title', 'Usulkan Komoditi Baru')

@section('content')
    @php
        $warnaStatus = ['disetujui' => 'success', 'menunggu_approval' => 'warning', 'ditolak' => 'danger'];
        $labelStatus = ['disetujui' => 'Disetujui', 'menunggu_approval' => 'Menunggu Approval', 'ditolak' => 'Ditolak'];
    @endphp

    <div class="row">
        <!-- Riwayat usulan milik user ini sendiri -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Usulan Saya</h4>
                </div>
                <div class="card-body">
                    <div class="text-muted small mb-3">
                        Semua komoditi yang pernah Anda usulkan, baik yang sudah disetujui maupun yang
                        masih menunggu - cek dulu di sini sebelum mengusulkan nama baru, supaya tidak
                        mengusulkan hal yang sama berulang-ulang.
                    </div>

                    @if ($riwayatSaya->isEmpty())
                        <div class="alert alert-info mb-0">Anda belum pernah mengusulkan komoditi.</div>
                    @else
                        <div style="max-height: 500px; overflow-y: auto;">
                            @foreach ($riwayatSaya as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <div>
                                        <div class="font-weight-bold">{{ $item->nama }}</div>
                                        <div class="text-muted small">{{ $item->kategoriKomoditi->nama ?? 'Tanpa kategori' }} &middot; {{ $item->created_at->translatedFormat('d M Y') }}</div>
                                    </div>
                                    <div class="text-right">
                                        <span class="badge badge-{{ $warnaStatus[$item->status] ?? 'secondary' }}">
                                            {{ $labelStatus[$item->status] ?? ucfirst($item->status) }}
                                        </span>
                                        @if ($item->status === 'menunggu_approval')
                                            <div class="mt-1">
                                                <a href="{{ route('komoditi.edit', $item) }}" class="small">Edit</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form usulan baru -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4>Usulkan Komoditi Baru</h4>
                </div>
                <div class="card-body">
                    <div class="text-muted small mb-3">
                        Usulan Anda akan direview dulu oleh Admin/Pusat sebelum bisa dipakai. Mulai
                        ketik nama komoditi di bawah - kalau ada nama mirip yang sudah pernah
                        diusulkan/terdaftar, akan langsung muncul sebagai saran supaya Anda tahu.
                    </div>
                    <form method="POST" action="{{ route('komoditi.simpanUsulan') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nama Komoditi <span class="text-danger">*</span></label>
                            <select name="nama" id="nama-komoditi-tag" data-placeholder="-- Input Nama --" class="select2-tags  @error('nama') is-invalid @enderror" style="width: 100%;">
                                <option value=""></option>
                                @if (old('nama'))
                                    <option value="{{ old('nama') }}" selected>{{ old('nama') }}</option>
                                @endif
                                @foreach ($semuaNamaKomoditi as $k)
                                    <option value="{{ $k->nama }}">
                                        {{ $k->nama }}@if ($k->status !== 'disetujui')
                                            ({{ $k->status === 'menunggu_approval' ? 'menunggu approval' : 'ditolak' }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('nama')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Contoh: ketik "Kakap" akan muncul "Kakap Merah", "Kakap Putih" kalau
                                sudah ada - kalau nama yang Anda maksud belum ada di saran, ketik nama
                                lengkapnya lalu tekan Enter untuk mengusulkan nama baru.
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Kategori (opsional)</label>
                            <select name="kategori_id" class="form-control select2" data-placeholder="-- Pilih Kategori --">
                                <option value=""></option>
                                @foreach ($kategoriList as $kat)
                                    <option value="{{ $kat->id }}" @selected(old('kategori_id') == $kat->id)>{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Kategori yang kamu maksud belum ada di daftar? Kosongkan dulu bagian ini,
                                nanti Admin/Pusat yang menambahkan kategorinya sebelum menyetujui usulan kamu.
                            </small>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Usulan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sengaja TIDAK pakai class umum ".select2" (yang di-auto-init tanpa opsi tags) -
            // field ini butuh mode tags:true supaya user bisa ketik nama baru selain memilih
            // dari saran nama yang sudah ada.
            $('#nama-komoditi-tag').select2({
                tags: true,
                width: '100%',
                placeholder: 'Ketik nama komoditi...',
                language: {
                    noResults: function() {
                        return 'Tidak ada saran - lanjutkan ketik nama baru.';
                    }
                }
            });
        });
    </script>
@endpush
