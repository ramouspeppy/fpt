@extends('layouts.app')

@section('title', 'Edit Penawaran')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('penawaran.update', $penawaran) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label required">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $penawaran->judul) }}" class="form-control @error('judul') is-invalid @enderror">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required">Tipe</label>
                    <select name="tipe" id="tipe" class="form-select @error('tipe') is-invalid @enderror">
                        <option value="Lokal" @selected(old('tipe', $penawaran->tipe)=='Lokal')>Lokal</option>
                        <option value="Ekspor" @selected(old('tipe', $penawaran->tipe)=='Ekspor')>Ekspor</option>
                        <option value="Ekspor & Lokal" @selected(old('tipe', $penawaran->tipe)=='Ekspor & Lokal')>Ekspor & Lokal</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required">Jenis Ikan</label>
                    <input type="text" name="jenis_ikan" value="{{ old('jenis_ikan', $penawaran->jenis_ikan) }}" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label required">Status</label>
                    <select name="status" class="form-select">
                        <option value="tersedia" @selected($penawaran->status=='tersedia')>Tersedia</option>
                        <option value="matched" @selected($penawaran->status=='matched')>Matched</option>
                        <option value="selesai" @selected($penawaran->status=='selesai')>Selesai</option>
                        <option value="ditutup" @selected($penawaran->status=='ditutup')>Ditutup</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label required">Volume (kg)</label>
                    <input type="number" step="0.01" name="volume" value="{{ old('volume', $penawaran->volume) }}" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" step="0.01" name="harga" value="{{ old('harga', $penawaran->harga) }}" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kondisi Ikan</label>
                    <input type="text" name="kondisi_ikan" value="{{ old('kondisi_ikan', $penawaran->kondisi_ikan) }}" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $penawaran->keterangan) }}</textarea>
            </div>

            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Grading</label>
                        <input type="text" name="grading" value="{{ old('grading', $penawaran->detailEkspor->grading ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi', $penawaran->detailEkspor->sertifikasi ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai', $penawaran->detailEkspor->kontinuitas_suplai ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Negara Tujuan</label>
                        <input type="text" name="negara_tujuan" value="{{ old('negara_tujuan', $penawaran->detailEkspor->negara_tujuan ?? '') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('penawaran.index') }}" class="btn btn-link">Batal</a>
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
        const val = tipeSelect.value;
        fieldEkspor.style.display = (val === 'Ekspor' || val === 'Ekspor & Lokal') ? 'block' : 'none';
    }

    tipeSelect.addEventListener('change', toggleFieldEkspor);
    toggleFieldEkspor();
</script>
@endsection
