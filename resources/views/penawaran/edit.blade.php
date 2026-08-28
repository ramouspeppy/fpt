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
                    <label class="form-label required">Komoditi</label>
                    <select name="komoditi_id" class="form-select @error('komoditi_id') is-invalid @enderror">
                        @foreach ($komoditiList as $kategori => $daftar)
                            <optgroup label="{{ $kategori ?? 'Lainnya' }}">
                                @foreach ($daftar as $k)
                                    <option value="{{ $k->id }}" @selected(old('komoditi_id', $penawaran->komoditi_id)==$k->id)>{{ $k->nama }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('komoditi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

            <div class="mb-3">
                <label class="form-label">Kondisi Ikan</label>
                <input type="text" name="kondisi_ikan" value="{{ old('kondisi_ikan', $penawaran->kondisi_ikan) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $penawaran->keterangan) }}</textarea>
            </div>

            <div class="card card-body bg-light mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Rincian Grade / Size</h4>
                    <button type="button" id="tambah-baris" class="btn btn-sm btn-outline-primary">
                        <i class="ti ti-plus"></i> Tambah Baris
                    </button>
                </div>

                <div id="baris-grade-container">
                    @forelse ($penawaran->rincianGrade as $rincian)
                        <div class="row baris-grade mb-2">
                            <div class="col-md-5">
                                <input type="text" name="grade[]" value="{{ $rincian->ukuran_grade }}" class="form-control" placeholder="Ukuran / Grade" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" step="0.01" name="harga[]" value="{{ $rincian->harga }}" class="form-control" placeholder="Harga per kg" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" step="0.01" name="kuantiti[]" value="{{ $rincian->kuantiti }}" class="form-control" placeholder="Kuantiti (kg)" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-danger hapus-baris"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>
                    @empty
                        <div class="row baris-grade mb-2">
                            <div class="col-md-5">
                                <input type="text" name="grade[]" class="form-control" placeholder="Ukuran / Grade" required>
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
                    @endforelse
                </div>
            </div>

            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi', $penawaran->detailEkspor->sertifikasi ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai', $penawaran->detailEkspor->kontinuitas_suplai ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
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
        semuaBaris.forEach((baris) => {
            baris.querySelector('.hapus-baris').style.display = semuaBaris.length > 1 ? 'inline-block' : 'none';
        });
    }
    perbaruiTombolHapus();
</script>
@endsection
