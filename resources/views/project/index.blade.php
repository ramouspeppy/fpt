@extends('layouts.app')

@section('title', 'Project')

@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item">Project</div>
@endsection

@section('content')
    @php
        $labelStatus = ['sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai', 'tutup' => 'Tutup'];
        $warnaStatus = ['sedang_diproses' => 'primary', 'selesai' => 'emerald', 'tutup' => 'secondary'];
        $ikonStatus = ['sedang_diproses' => 'fa-sync-alt', 'selesai' => 'fa-check-circle', 'tutup' => 'fa-lock'];
    @endphp

    <!-- Kartu statistik - sekaligus jadi pintasan filter -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('project.index') }}" class="text-decoration-none">
                <div class="card card-statistic-1 {{ !request('status') ? 'border-primary' : '' }}">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Project</h4>
                        </div>
                        <div class="card-body">{{ $statistik['total'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('project.index', ['status' => 'sedang_diproses']) }}" class="text-decoration-none">
                <div class="card card-statistic-1 {{ request('status') == 'sedang_diproses' ? 'border-primary' : '' }}">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Sedang Diproses</h4>
                        </div>
                        <div class="card-body">{{ $statistik['sedang_diproses'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('project.index', ['status' => 'selesai']) }}" class="text-decoration-none">
                <div class="card card-statistic-1 {{ request('status') == 'selesai' ? 'border-primary' : '' }}">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Selesai</h4>
                        </div>
                        <div class="card-body">{{ $statistik['selesai'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('project.index', ['status' => 'tutup']) }}" class="text-decoration-none">
                <div class="card card-statistic-1 {{ request('status') == 'tutup' ? 'border-primary' : '' }}">
                    <div class="card-icon bg-secondary">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Tutup</h4>
                        </div>
                        <div class="card-body">{{ $statistik['tutup'] }}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    @if (auth()->user()->hasRole('Cabang'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Menampilkan project yang melibatkan penawaran/permintaan cabang Anda saja.
        </div>
    @endif

    @if (request()->filled('status'))
        <div class="mb-2">
            <span class="text-muted">Filter aktif:</span>
            <span class="badge badge-{{ $warnaStatus[request('status')] ?? 'secondary' }}">{{ $labelStatus[request('status')] ?? request('status') }}</span>
            <a href="{{ route('project.index') }}" class="small ml-1">reset</a>
        </div>
    @endif

    <div class="row">
        @forelse ($projects as $project)
            @php $catatanTerakhir = $project->catatan->first(); @endphp
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-folder text-muted"></i> Project #{{ $project->id }}
                            </h5>
                            <span class="badge badge-{{ $warnaStatus[$project->status] ?? 'secondary' }}">
                                <i class="fas {{ $ikonStatus[$project->status] ?? 'fa-info-circle' }}"></i>
                                {{ $labelStatus[$project->status] ?? ucfirst($project->status) }}
                            </span>
                        </div>

                        <div class="card card-body bg-light py-2 px-3 mb-2">
                            <div class="small text-muted"><i class="fas fa-fish"></i> Penawaran</div>
                            <a href="{{ route('penawaran.show', $project->penawaran) }}">{{ $project->penawaran->judul }}</a>
                            <div class="small text-muted">{{ $project->penawaran->user->cabang->nama_cabang ?? '-' }}</div>
                        </div>
                        <div class="card card-body bg-light py-2 px-3 mb-3">
                            <div class="small text-muted"><i class="fas fa-clipboard-list"></i> Permintaan</div>
                            <a href="{{ route('permintaan.show', $project->permintaan) }}">{{ $project->permintaan->judul }}</a>
                            <div class="small text-muted">{{ $project->permintaan->user->cabang->nama_cabang ?? 'Pusat' }}</div>
                        </div>

                        @if ($catatanTerakhir)
                            <div class="small text-muted mb-3">
                                <i class="fas fa-comment-alt"></i>
                                Update terakhir {{ $catatanTerakhir->created_at->diffForHumans() }}
                                oleh {{ $catatanTerakhir->user->name ?? '-' }}
                            </div>
                        @else
                            <div class="small text-muted mb-3">
                                <i class="fas fa-comment-slash"></i> Belum ada catatan progress
                            </div>
                        @endif

                        <div class="text-muted small mb-3">
                            Dipilih oleh {{ $project->pemilih->name ?? '-' }} &middot; {{ $project->created_at->translatedFormat('d M Y, H:i') }}
                        </div>

                        <a href="{{ route('project.show', $project) }}" class="btn btn-sm btn-primary btn-block">
                            <i class="fas fa-eye"></i> Detail & Catatan Progress
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Belum ada Project{{ request()->filled('status') ? ' dengan status ini' : '' }}.
                    @unless (request()->filled('status'))
                        Project akan muncul di sini setelah Pusat/Admin memilih kandidat kecocokan di halaman Kecocokan.
                    @endunless
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $projects->links('pagination::bootstrap-4') }}</div>
@endsection
