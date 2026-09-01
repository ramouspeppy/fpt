@extends('layouts.app')

@section('title', 'Tambah Permintaan')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('permintaan.store') }}">
            @csrf

            <div class="form-group">
                <label>Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" placeholder="mis. Permintaan Gurita Ekspor - PT Sumber Laut Jaya">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Tipe <span class="text-danger">*</span></label>
                    <select name="tipe" id="tipe" class="form-control selectric @error('tipe') is-invalid @enderror">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Lokal" @selected(old('tipe')=='Lokal')>Lokal</option>
                        <option value="Ekspor" @selected(old('tipe')=='Ekspor')>Ekspor</option>
                    </select>
                    @error('tipe') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label>Komoditi <span class="text-danger">*</span></label>
                    <select name="komoditi_id" id="komoditi_id" class="form-control select2 @error('komoditi_id') is-invalid @enderror" data-placeholder="-- Pilih Komoditi --">
                        <option value=""></option>
                        @foreach ($komoditiList as $kategori => $daftar)
                            <optgroup label="{{ $kategori ?? 'Lainnya' }}">
                                @foreach ($daftar as $k)
                                    <option value="{{ $k->id }}" @selected(old('komoditi_id')==$k->id)>{{ $k->nama }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('komoditi_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <small class="form-text text-muted">
                        Tidak menemukan komoditi yang dicari?
                        <a href="{{ route('komoditi.usulkan') }}" target="_blank">Usulkan komoditi baru</a>
                    </small>
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Rincian Size -->
            <div class="card card-body bg-light mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Rincian Size Dibutuhkan</h4>
                    <button type="button" id="tambah-baris" class="btn btn-sm btn-primary" disabled>
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>
                </div>
                <div class="text-muted small mb-2" id="hint-size">
                    Pilih Komoditi terlebih dahulu supaya daftar size-nya muncul di sini.
                </div>

                <div id="baris-size-container">
                    <div class="row baris-size mb-2">
                        <div class="col-md-5">
                            <select name="komoditi_size_id[]" class="form-control komoditi-size-select" required disabled>
                                <option value="">-- Pilih Komoditi dulu --</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="harga[]" class="form-control" placeholder="Harga per kg" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="kuantiti[]" class="form-control" placeholder="Kuantiti dibutuhkan (kg)" required>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger hapus-baris" style="display:none;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            @role('Pusat|Admin')
            <div class="card card-body bg-light mb-3">
                <h4 class="mb-3">Indikator Prioritas (khusus tim Pusat)</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Warna Prioritas</label>
                        <select name="prioritas_warna" class="form-control selectric">
                            <option value="">-- Tidak ada --</option>
                            <option value="merah" @selected(old('prioritas_warna')=='merah')>Merah (Urgent)</option>
                            <option value="kuning" @selected(old('prioritas_warna')=='kuning')>Kuning (Biasa)</option>
                            <option value="hijau" @selected(old('prioritas_warna')=='hijau')>Hijau (Tidak Mendesak)</option>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tag Konteks</label>
                        <input type="text" name="prioritas_tag" value="{{ old('prioritas_tag') }}" class="form-control" placeholder="mis. Urgent - buyer nunggu 3 hari">
                    </div>
                </div>
            </div>
            @endrole

            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi') }}" class="form-control" placeholder="mis. HACCP">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai') }}" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Negara Tujuan</label>
                        <input type="text" name="negara_tujuan" value="{{ old('negara_tujuan') }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('permintaan.index') }}" class="btn btn-link">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Permintaan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const sizesByKomoditi = {!! $sizesByKomoditi !!};

    document.addEventListener('DOMContentLoaded', function () {
        const tipeSelect = document.getElementById('tipe');
        const fieldEkspor = document.getElementById('field-ekspor');
        function toggleFieldEkspor() {
            fieldEkspor.style.display = (tipeSelect.value === 'Ekspor') ? 'block' : 'none';
        }
        tipeSelect.addEventListener('change', toggleFieldEkspor);
        toggleFieldEkspor();

        const komoditiSelect = document.getElementById('komoditi_id');
        const hintSize = document.getElementById('hint-size');
        const tambahBarisBtn = document.getElementById('tambah-baris');

        function isiDropdownSize(selectEl, komoditiId, nilaiTerpilih) {
            const daftar = sizesByKomoditi[komoditiId] || [];
            selectEl.innerHTML = '';

            if (!komoditiId) {
                selectEl.innerHTML = '<option value="">-- Pilih Komoditi dulu --</option>';
                selectEl.disabled = true;
                return;
            }

            if (daftar.length === 0) {
                selectEl.innerHTML = '<option value="">-- Belum ada size untuk komoditi ini --</option>';
                selectEl.disabled = true;
                return;
            }

            selectEl.innerHTML = '<option value="">-- Pilih Size --</option>' +
                daftar.map(s => `<option value="${s.id}" ${String(s.id) === String(nilaiTerpilih) ? 'selected' : ''}>${s.nama_size}</option>`).join('');
            selectEl.disabled = false;
        }

        function perbaruiSemuaDropdownSize() {
            const komoditiId = komoditiSelect.value;
            document.querySelectorAll('.komoditi-size-select').forEach(el => isiDropdownSize(el, komoditiId));

            if (komoditiId) {
                hintSize.innerHTML = 'Tidak menemukan size yang dicari? <a href="/komoditi/' + komoditiId + '/size/usulkan" target="_blank">Usulkan size baru</a>.';
                tambahBarisBtn.disabled = !(sizesByKomoditi[komoditiId] && sizesByKomoditi[komoditiId].length);
            } else {
                hintSize.textContent = 'Pilih Komoditi terlebih dahulu supaya daftar size-nya muncul di sini.';
                tambahBarisBtn.disabled = true;
            }
        }

        komoditiSelect.addEventListener('change', perbaruiSemuaDropdownSize);
        $(komoditiSelect).on('select2:select select2:clear', perbaruiSemuaDropdownSize);
        if (komoditiSelect.value) {
            perbaruiSemuaDropdownSize();
        }

        const container = document.getElementById('baris-size-container');
        tambahBarisBtn.addEventListener('click', function () {
            const baris = container.querySelector('.baris-size').cloneNode(true);
            baris.querySelectorAll('input').forEach(input => input.value = '');
            isiDropdownSize(baris.querySelector('.komoditi-size-select'), komoditiSelect.value);
            baris.querySelector('.hapus-baris').style.display = 'inline-block';
            container.appendChild(baris);
            perbaruiTombolHapus();
        });

        container.addEventListener('click', function (e) {
            if (e.target.closest('.hapus-baris')) {
                e.target.closest('.baris-size').remove();
                perbaruiTombolHapus();
            }
        });

        function perbaruiTombolHapus() {
            const semuaBaris = container.querySelectorAll('.baris-size');
            semuaBaris.forEach((baris) => {
                baris.querySelector('.hapus-baris').style.display = semuaBaris.length > 1 ? 'inline-block' : 'none';
            });
        }
    });
</script>
@endsection
