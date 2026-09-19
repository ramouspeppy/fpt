@extends('layouts.app')

@section('title', 'Kecocokan Penawaran & Permintaan')

@php
    $adaFilterAktif = request()->anyFilled(['komoditi_id', 'penawaran_id', 'permintaan_id', 'status']);
@endphp

@section('content')
    <form method="GET" id="form-filter-match">

        <div class="card">
            <div class="card-header">
                <h4>Filter</h4>
                <div class="card-header-action">
                    @if ($adaFilterAktif)
                        <a href="{{ route('match.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Reset Filter
                        </a>
                    @endif

                    <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-{{ $adaFilterAktif ? 'minus' : 'plus' }}"></i></a>
                </div>
            </div>
            <div class="collapse{{ $adaFilterAktif ? ' show' : '' }}" id="mycard-collapse">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <select name="komoditi_id" class="form-control select2" data-placeholder="Semua Komoditi..." onchange="document.getElementById('form-filter-match').submit()">
                                    <option value=""></option>
                                    @foreach ($opsiKomoditi as $opsi)
                                        <option value="{{ $opsi->id }}" @selected(request('komoditi_id') == $opsi->id)>{{ $opsi->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <select name="status" class="form-control selectric" onchange="document.getElementById('form-filter-match').submit()">
                                    <option value="">Semua Status</option>
                                    <option value="terbuka" @selected(request('status') == 'terbuka')>Terbuka (belum dipilih)</option>
                                    <option value="dipilih" @selected(request('status') == 'dipilih')>Sudah Dipilih (Project)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <select name="penawaran_id" class="form-control select2" data-placeholder="Filter per Penawaran..." onchange="document.getElementById('form-filter-match').submit()">
                                    <option value=""></option>
                                    @foreach ($opsiPenawaran as $opsi)
                                        <option value="{{ $opsi->id }}" @selected(request('penawaran_id') == $opsi->id)>{{ $opsi->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <select name="permintaan_id" class="form-control select2" data-placeholder="Filter per Permintaan..." onchange="document.getElementById('form-filter-match').submit()">
                                    <option value=""></option>
                                    @foreach ($opsiPermintaan as $opsi)
                                        <option value="{{ $opsi->id }}" @selected(request('permintaan_id') == $opsi->id)>{{ $opsi->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <!-- Form GET terpisah khusus urutan, bawa serta filter yang sedang aktif
                         lewat hidden input supaya ganti urutan tidak menghapus filter yang dipilih. -->
                    <form method="GET" id="form-urutan-match">
                        <input type="hidden" name="komoditi_id" value="{{ request('komoditi_id') }}">
                        <input type="hidden" name="penawaran_id" value="{{ request('penawaran_id') }}">
                        <input type="hidden" name="permintaan_id" value="{{ request('permintaan_id') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <div class="form-group mb-0">
                            <select name="urutan" class="form-control selectric" onchange="this.form.submit()">
                                <option value="profit" @selected($urutan == 'profit')>Estimasi Profit Terbesar</option>
                                <option value="persen" @selected($urutan == 'persen')>% Profit Terbesar</option>
                                <option value="terbaru" @selected($urutan == 'terbaru')>Terbaru</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-md-right">
                    <form method="POST" action="{{ route('match.jalankan') }}" class="d-inline-block mb-0">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-sync-alt"></i> Jalankan Pencocokan Ulang
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-muted small mt-2 mb-0">
                Sistem akan mencari ulang seluruh kemungkinan pasangan Penawaran &amp; Permintaan yang cocok, berdasarkan data terbaru.
            </p>
        </div>
    </div>

    @if (request()->filled('komoditi_id') || request()->filled('penawaran_id') || request()->filled('permintaan_id'))
        <div class="alert alert-light">
            Menampilkan <strong>{{ $matches->total() }}</strong> pasangan kandidat
            @if (request()->filled('komoditi_id'))
                untuk Komoditi: <strong>{{ optional($opsiKomoditi->firstWhere('id', request('komoditi_id')))->nama }}</strong>
            @endif
            @if (request()->filled('penawaran_id'))
                {{ request()->filled('komoditi_id') ? '&' : 'untuk' }} Penawaran: <strong>{{ optional($opsiPenawaran->firstWhere('id', request('penawaran_id')))->judul }}</strong>
            @endif
            @if (request()->filled('permintaan_id'))
                {{ request()->anyFilled(['komoditi_id', 'penawaran_id']) ? '&' : 'untuk' }} Permintaan: <strong>{{ optional($opsiPermintaan->firstWhere('id', request('permintaan_id')))->judul }}</strong>
            @endif
        </div>
    @endif

    @if (auth()->user()->hasRole('Cabang'))
        <div class="alert alert-info">Menampilkan kecocokan yang melibatkan penawaran/permintaan cabang Anda saja.</div>
    @endif

    @if (auth()->user()->hasAnyRole(['Pusat', 'Admin']))
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Setiap pasangan kecocokan (Lokal maupun Ekspor) harus Anda
            pilih secara manual untuk dijadikan Project. Kalau 1 Permintaan punya beberapa kandidat dari
            cabang berbeda, pilih salah satu yang paling sesuai — kandidat lain akan otomatis hilang dari
            daftar ini setelah Permintaan/Penawaran terkait terkunci.
        </div>
    @endif

    @php
        $labelStatus = ['terbuka' => 'Terbuka', 'dipilih' => 'Sudah Dipilih'];
        $warnaStatus = ['terbuka' => 'warning', 'dipilih' => 'emerald'];
    @endphp

    @forelse ($matches as $match)
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                    <div>
                        @if ($match->jumlah_size_cocok > 1)
                            <span class="badge badge-secondary"><i class="fas fa-layer-group"></i> {{ $match->jumlah_size_cocok }} size cocok di pasangan ini</span>
                        @endif
                    </div>
                    <div>
                        <span class="badge badge-{{ $match->warna_profit_kelompok }} p-2">
                            <i class="fas fa-coins"></i>
                            Estimasi Profit: Rp {{ number_format($match->total_profit_kelompok, 0) }}
                            ({{ number_format($match->persen_profit_kelompok * 100, 1) }}%)
                        </span>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="text-muted small font-weight-bold">PENAWARAN</div>
                        <a href="{{ route('penawaran.show', $match->penawaran) }}"><strong>{{ $match->penawaran->judul }}</strong></a>
                        <div class="small text-muted">
                            {{ $match->penawaran->komoditi->nama ?? '-' }} &middot; {{ $match->penawaran->user->cabang->nama_cabang ?? '-' }}
                        </div>
                    </div>
                    <div class="col-md-2 text-center d-none d-md-block">
                        <i class="fas fa-exchange-alt fa-2x text-muted"></i>
                    </div>
                    <div class="col-md-5">
                        <div class="text-muted small font-weight-bold">PERMINTAAN</div>
                        <a href="{{ route('permintaan.show', $match->permintaan) }}"><strong>{{ $match->permintaan->judul }}</strong></a>
                        <div class="small text-muted">
                            {{ $match->permintaan->komoditi->nama ?? '-' }} &middot; {{ $match->permintaan->user->cabang->nama_cabang ?? 'Pusat' }}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge badge-{{ $warnaStatus[$match->status] ?? 'secondary' }}">
                            {{ $labelStatus[$match->status] ?? ucfirst($match->status) }}
                        </span>
                        <span class="text-muted small ml-2">Skor: {{ $match->skor_matching }}</span>
                    </div>
                    @if ($match->status === 'dipilih' && $match->project)
                        <a href="{{ route('project.show', $match->project) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-folder-open"></i> Lihat Project
                        </a>
                    @else
                        <a href="{{ route('match.show', $match) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Lihat Detail & Bandingkan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Belum ada kecocokan ditemukan. Coba klik "Cari Kecocokan Ulang".</div>
    @endforelse

    <div class="mt-3">{{ $matches->links('pagination::bootstrap-4') }}</div>
@endsection
