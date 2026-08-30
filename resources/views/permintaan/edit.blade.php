@extends('layouts.app')

@section('title', 'Edit Permintaan')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('permintaan.update', $permintaan) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $permintaan->judul) }}" class="form-control @error('judul') is-invalid @enderror">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label>Tipe <span class="text-danger">*</span></label>
                    <select name="tipe" id="tipe" class="form-control selectric">
                        <option value="Lokal" @selected(old('tipe', $permintaan->tipe)=='Lokal')>Lokal</option>
                        <option value="Ekspor" @selected(old('tipe', $permintaan->tipe)=='Ekspor')>Ekspor</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Komoditi <span class="text-danger">*</span></label>
                    <select name="komoditi_id" class="form-control select2 @error('komoditi_id') is-invalid @enderror">
                        @foreach ($komoditiList as $kategori => $daftar)
                            <optgroup label="{{ $kategori ?? 'Lainnya' }}">
                                @foreach ($daftar as $k)
                                    <option value="{{ $k->id }}" @selected(old('komoditi_id', $permintaan->komoditi_id)==$k->id)>{{ $k->nama }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('komoditi_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control selectric">
                        <option value="tersedia" @selected($permintaan->status=='tersedia')>Tersedia</option>
                        <option value="matched" @selected($permintaan->status=='matched')>Matched</option>
                        <option value="selesai" @selected($permintaan->status=='selesai')>Selesai</option>
                        <option value="ditutup" @selected($permintaan->status=='ditutup')>Ditutup</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $permintaan->keterangan) }}</textarea>
            </div>

            <div class="card card-body bg-light mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Rincian Grade / Size Dibutuhkan</h4>
                    <button type="button" id="tambah-baris" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>
                </div>

                <div id="baris-grade-container">
                    @forelse ($permintaan->rincianGrade as $rincian)
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
                                <button type="button" class="btn btn-danger hapus-baris"><i class="fas fa-trash"></i></button>
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
                                <button type="button" class="btn btn-danger hapus-baris" style="display:none;"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            @role('Pusat|Admin')
            <div class="card card-body bg-light mb-3">
                <h4 class="mb-3">Indikator Prioritas</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Warna Prioritas</label>
                        <select name="prioritas_warna" class="form-control selectric">
                            <option value="">-- Tidak ada --</option>
                            <option value="merah" @selected(old('prioritas_warna', $permintaan->prioritas_warna)=='merah')>Merah (Urgent)</option>
                            <option value="kuning" @selected(old('prioritas_warna', $permintaan->prioritas_warna)=='kuning')>Kuning (Biasa)</option>
                            <option value="hijau" @selected(old('prioritas_warna', $permintaan->prioritas_warna)=='hijau')>Hijau (Tidak Mendesak)</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tag Konteks</label>
                        <input type="text" name="prioritas_tag" value="{{ old('prioritas_tag', $permintaan->prioritas_tag) }}" class="form-control">
                    </div>
                </div>
            </div>
            @endrole

            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi', $permintaan->detailEkspor->sertifikasi ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai', $permintaan->detailEkspor->kontinuitas_suplai ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Negara Tujuan</label>
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
    document.addEventListener('DOMContentLoaded', function () {
        const tipeSelect = document.getElementById('tipe');
        const fieldEkspor = document.getElementById('field-ekspor');
        function toggleFieldEkspor() {
            fieldEkspor.style.display = (tipeSelect.value === 'Ekspor') ? 'block' : 'none';
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
    });
</script>
@endsection
