@extends('layouts.app')

@section('title', 'Tambah Penawaran')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('penawaran.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label required">Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" placeholder="mis. Surplus Gurita Berbagai Grade - Cabang Medan">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Tipe</label>
                    <select name="tipe" id="tipe" class="form-select @error('tipe') is-invalid @enderror">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Lokal" @selected(old('tipe')=='Lokal')>Lokal</option>
                        <option value="Ekspor" @selected(old('tipe')=='Ekspor')>Ekspor</option>
                        <option value="Ekspor & Lokal" @selected(old('tipe')=='Ekspor & Lokal')>Ekspor & Lokal</option>
                    </select>
                    @error('tipe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Jenis Ikan</label>
                    <input type="text" name="jenis_ikan" value="{{ old('jenis_ikan') }}" class="form-control @error('jenis_ikan') is-invalid @enderror" placeholder="mis. Gurita">
                    @error('jenis_ikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kondisi Ikan</label>
                <input type="text" name="kondisi_ikan" value="{{ old('kondisi_ikan') }}" class="form-control" placeholder="Segar / Beku">
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Rincian Grade - baris bisa ditambah/hapus -->
            <div class="card card-body bg-light mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Rincian Grade / Size</h4>
                    <button type="button" id="tambah-baris" class="btn btn-sm btn-outline-primary">
                        <i class="ti ti-plus"></i> Tambah Baris
                    </button>
                </div>
                <div class="text-muted small mb-2">
                    Contoh: "1.000-Up", "500-1.000 A", "300-500 B", "200-300 C" — satu jenis ikan bisa
                    punya beberapa grade dengan harga & kuantiti berbeda.
                </div>

                <div id="baris-grade-container">
                    <div class="row baris-grade mb-2">
                        <div class="col-md-5">
                            <input type="text" name="grade[]" class="form-control" placeholder="Ukuran / Grade (mis. 1.000-Up)" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="harga[]" class="form-control" placeholder="Harga per kg" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="kuantiti[]" class="form-control" placeholder="Kuantiti (kg)" required>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-outline-danger hapus-baris" style="display:none;"><i class="ti ti-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field ekspor - muncul dinamis jika tipe mengandung "Ekspor" -->
            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi') }}" class="form-control" placeholder="mis. HACCP">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai') }}" class="form-control" placeholder="Self-declare, mis. 'Rutin tiap minggu'">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Negara Tujuan</label>
                        <input type="text" name="negara_tujuan" value="{{ old('negara_tujuan') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('penawaran.index') }}" class="btn btn-link">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Penawaran</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // toggle field ekspor
    const tipeSelect = document.getElementById('tipe');
    const fieldEkspor = document.getElementById('field-ekspor');
    function toggleFieldEkspor() {
        const val = tipeSelect.value;
        fieldEkspor.style.display = (val === 'Ekspor' || val === 'Ekspor & Lokal') ? 'block' : 'none';
    }
    tipeSelect.addEventListener('change', toggleFieldEkspor);
    toggleFieldEkspor();

    // tambah/hapus baris rincian grade
    const container = document.getElementById('baris-grade-container');
    document.getElementById('tambah-baris').addEventListener('click', function () {
        const baris = container.querySelector('.baris-grade').cloneNode(true);
        baris.querySelectorAll('input').forEach(input => input.value = '');
        baris.querySelector('.hapus-baris').style.display = 'inline-block';
        container.appendChild(baris);
        perbaruiTombolHapus();
    });

    container.addEventListener('click', function (e) {
        if (e.target.closest('.hapus-baris')) {
            e.target.closest('.baris-grade').remove();
            perbaruiTombolHapus();
        }
    });

    function perbaruiTombolHapus() {
        const semuaBaris = container.querySelectorAll('.baris-grade');
        semuaBaris.forEach((baris, index) => {
            const tombolHapus = baris.querySelector('.hapus-baris');
            tombolHapus.style.display = semuaBaris.length > 1 ? 'inline-block' : 'none';
        });
    }
</script>
@endsection
