@extends('layouts.app')

@section('title', 'Tambah Penawaran')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('penawaran.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label required">Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" placeholder="mis. Surplus Kembung Kuring 500kg - Cabang Medan">
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
                    <input type="text" name="jenis_ikan" value="{{ old('jenis_ikan') }}" class="form-control @error('jenis_ikan') is-invalid @enderror">
                    @error('jenis_ikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required">Volume (kg)</label>
                    <input type="number" step="0.01" name="volume" value="{{ old('volume') }}" class="form-control @error('volume') is-invalid @enderror">
                    @error('volume') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga (opsional)</label>
                    <input type="number" step="0.01" name="harga" value="{{ old('harga') }}" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kondisi Ikan</label>
                    <input type="text" name="kondisi_ikan" value="{{ old('kondisi_ikan') }}" class="form-control" placeholder="Segar / Beku">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Field ekspor - muncul dinamis jika tipe mengandung "Ekspor" -->
            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Grading (size, kesegaran)</label>
                        <input type="text" name="grading" value="{{ old('grading') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi') }}" class="form-control" placeholder="mis. HACCP">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai') }}" class="form-control" placeholder="Self-declare, mis. 'Rutin tiap minggu'">
                    </div>
                    <div class="col-md-6 mb-3">
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
    const tipeSelect = document.getElementById('tipe');
    const fieldEkspor = document.getElementById('field-ekspor');

    function toggleFieldEkspor() {
        const val = tipeSelect.value;
        fieldEkspor.style.display = (val === 'Ekspor' || val === 'Ekspor & Lokal') ? 'block' : 'none';
    }

    tipeSelect.addEventListener('change', toggleFieldEkspor);
    toggleFieldEkspor(); // jalankan saat load, misal setelah validasi gagal (old value)
</script>
@endsection
