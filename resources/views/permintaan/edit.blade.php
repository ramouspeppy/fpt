@extends('layouts.app')

@section('title', 'Edit Permintaan')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('permintaan.update', $permintaan) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label required">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $permintaan->judul) }}" class="form-control @error('judul') is-invalid @enderror">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required">Tipe</label>
                    <select name="tipe" id="tipe" class="form-select">
                        <option value="Lokal" @selected(old('tipe', $permintaan->tipe)=='Lokal')>Lokal</option>
                        <option value="Ekspor" @selected(old('tipe', $permintaan->tipe)=='Ekspor')>Ekspor</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required">Jenis Ikan</label>
                    <input type="text" name="jenis_ikan" value="{{ old('jenis_ikan', $permintaan->jenis_ikan) }}" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required">Status</label>
                    <select name="status" class="form-select">
                        <option value="tersedia" @selected($permintaan->status=='tersedia')>Tersedia</option>
                        <option value="matched" @selected($permintaan->status=='matched')>Matched</option>
                        <option value="selesai" @selected($permintaan->status=='selesai')>Selesai</option>
                        <option value="ditutup" @selected($permintaan->status=='ditutup')>Ditutup</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Volume Dibutuhkan (kg)</label>
                    <input type="number" step="0.01" name="volume" value="{{ old('volume', $permintaan->volume) }}" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Maksimal</label>
                    <input type="number" step="0.01" name="harga_maksimal" value="{{ old('harga_maksimal', $permintaan->harga_maksimal) }}" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $permintaan->keterangan) }}</textarea>
            </div>

            @role('Pusat|Admin')
            <div class="card card-body bg-light mb-3">
                <h4 class="mb-3">Indikator Prioritas</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Warna Prioritas</label>
                        <select name="prioritas_warna" class="form-select">
                            <option value="">-- Tidak ada --</option>
                            <option value="merah" @selected(old('prioritas_warna', $permintaan->prioritas_warna)=='merah')>Merah (Urgent)</option>
                            <option value="kuning" @selected(old('prioritas_warna', $permintaan->prioritas_warna)=='kuning')>Kuning (Biasa)</option>
                            <option value="hijau" @selected(old('prioritas_warna', $permintaan->prioritas_warna)=='hijau')>Hijau (Tidak Mendesak)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tag Konteks</label>
                        <input type="text" name="prioritas_tag" value="{{ old('prioritas_tag', $permintaan->prioritas_tag) }}" class="form-control">
                    </div>
                </div>
            </div>
            @endrole

            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Grading</label>
                        <input type="text" name="grading" value="{{ old('grading', $permintaan->detailEkspor->grading ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi', $permintaan->detailEkspor->sertifikasi ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai', $permintaan->detailEkspor->kontinuitas_suplai ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Negara Tujuan</label>
                        <input type="text" name="negara_tujuan" value="{{ old('negara_tujuan', $permintaan->detailEkspor->negara_tujuan ?? '') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('permintaan.index') }}" class="btn btn-link">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
        fieldEkspor.style.display = (tipeSelect.value === 'Ekspor') ? 'block' : 'none';
    }

    tipeSelect.addEventListener('change', toggleFieldEkspor);
    toggleFieldEkspor();
</script>
@endsection
