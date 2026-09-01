@extends('layouts.app')

@section('title', 'Edit Penawaran')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('penawaran.update', $penawaran) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $penawaran->judul) }}" class="form-control @error('judul') is-invalid @enderror">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-3 form-group">
                    <label>Tipe <span class="text-danger">*</span></label>
                    <select name="tipe" id="tipe" class="form-control selectric @error('tipe') is-invalid @enderror">
                        <option value="Lokal" @selected(old('tipe', $penawaran->tipe)=='Lokal')>Lokal</option>
                        <option value="Ekspor" @selected(old('tipe', $penawaran->tipe)=='Ekspor')>Ekspor</option>
                        <option value="Ekspor & Lokal" @selected(old('tipe', $penawaran->tipe)=='Ekspor & Lokal')>Ekspor & Lokal</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label>Jenis Penawaran <span class="text-danger">*</span></label>
                    <select name="jenis_penawaran" id="jenis_penawaran" class="form-control selectric @error('jenis_penawaran') is-invalid @enderror">
                        <option value="Produksi Sendiri" @selected(old('jenis_penawaran', $penawaran->jenis_penawaran)=='Produksi Sendiri')>Produksi Sendiri</option>
                        <option value="Trading" @selected(old('jenis_penawaran', $penawaran->jenis_penawaran)=='Trading')>Trading / Beli Jadi dari Mitra</option>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label>Komoditi <span class="text-danger">*</span></label>
                    <select name="komoditi_id" id="komoditi_id" class="form-control select2 @error('komoditi_id') is-invalid @enderror">
                        @foreach ($komoditiList as $kategori => $daftar)
                            <optgroup label="{{ $kategori ?? 'Lainnya' }}">
                                @foreach ($daftar as $k)
                                    <option value="{{ $k->id }}" @selected(old('komoditi_id', $penawaran->komoditi_id)==$k->id)>{{ $k->nama }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('komoditi_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control selectric">
                        <option value="tersedia" @selected($penawaran->status=='tersedia')>Tersedia</option>
                        <option value="selesai" @selected($penawaran->status=='selesai')>Selesai</option>
                        <option value="tutup" @selected($penawaran->status=='tutup')>Tutup</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Kondisi Ikan</label>
                <input type="text" name="kondisi_ikan" value="{{ old('kondisi_ikan', $penawaran->kondisi_ikan) }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $penawaran->keterangan) }}</textarea>
            </div>

            <div class="card card-body bg-light mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Rincian Size</h4>
                    <button type="button" id="tambah-baris" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>
                </div>
                <div class="text-muted small mb-2" id="hint-size">
                    Tidak menemukan size yang dicari?
                    <a href="{{ route('komoditi.size.usulkan', $penawaran->komoditi_id) }}" id="link-usulkan-size" target="_blank">Usulkan size baru</a>.
                </div>

                <div id="baris-size-container">
                    @foreach ($penawaran->rincianSize as $rincian)
                        <div class="row baris-size mb-2">
                            <div class="col-md-5">
                                <select name="komoditi_size_id[]" class="form-control komoditi-size-select" data-selected="{{ $rincian->komoditi_size_id }}" required></select>
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
                    @endforeach
                </div>
            </div>

            <!-- Rincian Biaya HPP / Margin - WAJIB diisi, label berubah sesuai Jenis Penawaran -->
            <div class="card card-body bg-light mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0" id="judul-section-biaya">Rincian Biaya HPP <span class="text-danger">*</span></h4>
                    <button type="button" id="tambah-baris-biaya" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Biaya
                    </button>
                </div>
                <div class="text-muted small mb-2" id="hint-section-biaya">
                    Biaya operasional per kg — berlaku sama untuk semua size di atas, otomatis
                    ditambahkan ke harga beli sebagai Harga Jual.
                </div>

                <div id="baris-biaya-container">
                    @forelse ($penawaran->biayaHpp as $biaya)
                        <div class="row baris-biaya mb-2">
                            <div class="col-md-7">
                                <input type="text" name="biaya_label[]" value="{{ $biaya->label }}" class="form-control" placeholder="mis. Biaya Proses" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="biaya_jumlah[]" value="{{ $biaya->jumlah }}" class="form-control" placeholder="Rp per kg" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger hapus-baris-biaya"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @empty
                        <div class="row baris-biaya mb-2">
                            <div class="col-md-7">
                                <input type="text" name="biaya_label[]" class="form-control" placeholder="mis. Biaya Proses" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="biaya_jumlah[]" class="form-control" placeholder="Rp per kg" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger hapus-baris-biaya" style="display:none;"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi', $penawaran->detailEkspor->sertifikasi ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai', $penawaran->detailEkspor->kontinuitas_suplai ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Negara Tujuan</label>
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
    const sizesByKomoditi = {!! $sizesByKomoditi !!};

    document.addEventListener('DOMContentLoaded', function () {
        const tipeSelect = document.getElementById('tipe');
        const fieldEkspor = document.getElementById('field-ekspor');
        function toggleFieldEkspor() {
            const val = tipeSelect.value;
            fieldEkspor.style.display = (val === 'Ekspor' || val === 'Ekspor & Lokal') ? 'block' : 'none';
        }
        tipeSelect.addEventListener('change', toggleFieldEkspor);
        toggleFieldEkspor();

        const jenisPenawaranSelect = document.getElementById('jenis_penawaran');
        const judulSectionBiaya = document.getElementById('judul-section-biaya');
        const hintSectionBiaya = document.getElementById('hint-section-biaya');

        function toggleLabelBiaya() {
            if (jenisPenawaranSelect.value === 'Trading') {
                judulSectionBiaya.innerHTML = 'Margin / Keuntungan <span class="text-danger">*</span>';
                hintSectionBiaya.textContent = 'Karena barang sudah jadi dari mitra, cukup isi margin/keuntungan yang Anda inginkan per kg.';
            } else {
                judulSectionBiaya.innerHTML = 'Rincian Biaya HPP <span class="text-danger">*</span>';
                hintSectionBiaya.textContent = 'Biaya operasional per kg — berlaku sama untuk semua size di atas, otomatis ditambahkan ke harga beli sebagai Harga Jual.';
            }
        }
        jenisPenawaranSelect.addEventListener('change', toggleLabelBiaya);
        toggleLabelBiaya();

        // ---- Dropdown size, cascading berdasarkan Komoditi yang dipilih ----
        const komoditiSelect = document.getElementById('komoditi_id');
        const hintSize = document.getElementById('hint-size');

        function isiDropdownSize(selectEl, komoditiId, pertahankanNilaiLama) {
            const nilaiTerpilih = pertahankanNilaiLama ? selectEl.dataset.selected : '';
            const daftar = sizesByKomoditi[komoditiId] || [];
            selectEl.innerHTML = '';

            if (!komoditiId || daftar.length === 0) {
                selectEl.innerHTML = '<option value="">-- Belum ada size untuk komoditi ini --</option>';
                selectEl.disabled = true;
                return;
            }

            selectEl.innerHTML = '<option value="">-- Pilih Size --</option>' +
                daftar.map(s => `<option value="${s.id}" ${String(s.id) === String(nilaiTerpilih) ? 'selected' : ''}>${s.nama_size}</option>`).join('');
            selectEl.disabled = false;
        }

        function perbaruiSemuaDropdownSize(pertahankanNilaiLama) {
            const komoditiId = komoditiSelect.value;
            document.querySelectorAll('.komoditi-size-select').forEach(el => isiDropdownSize(el, komoditiId, pertahankanNilaiLama));
            hintSize.innerHTML = komoditiId
                ? 'Tidak menemukan size yang dicari? <a href="/komoditi/' + komoditiId + '/size/usulkan" target="_blank">Usulkan size baru</a>.'
                : 'Pilih Komoditi terlebih dahulu.';
        }

        // Saat load pertama: pertahankan size yang sudah tersimpan (data-selected)
        perbaruiSemuaDropdownSize(true);

        // Kalau Komoditi diganti manual: size direset (tidak ada relevansi ke size lama)
        komoditiSelect.addEventListener('change', () => perbaruiSemuaDropdownSize(false));
        $(komoditiSelect).on('select2:select select2:clear', () => perbaruiSemuaDropdownSize(false));

        const container = document.getElementById('baris-size-container');
        document.getElementById('tambah-baris').addEventListener('click', function () {
            const baris = container.querySelector('.baris-size').cloneNode(true);
            baris.querySelectorAll('input').forEach(input => input.value = '');
            isiDropdownSize(baris.querySelector('.komoditi-size-select'), komoditiSelect.value, false);
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
        perbaruiTombolHapus();

        const containerBiaya = document.getElementById('baris-biaya-container');
        document.getElementById('tambah-baris-biaya').addEventListener('click', function () {
            const baris = containerBiaya.querySelector('.baris-biaya').cloneNode(true);
            baris.querySelectorAll('input').forEach(input => input.value = '');
            baris.querySelector('.hapus-baris-biaya').style.display = 'inline-block';
            containerBiaya.appendChild(baris);
            perbaruiTombolHapusBiaya();
        });

        containerBiaya.addEventListener('click', function (e) {
            if (e.target.closest('.hapus-baris-biaya')) {
                e.target.closest('.baris-biaya').remove();
                perbaruiTombolHapusBiaya();
            }
        });

        function perbaruiTombolHapusBiaya() {
            const semuaBaris = containerBiaya.querySelectorAll('.baris-biaya');
            semuaBaris.forEach((baris) => {
                baris.querySelector('.hapus-baris-biaya').style.display = semuaBaris.length > 1 ? 'inline-block' : 'none';
            });
        }
        perbaruiTombolHapusBiaya();
    });
</script>
@endsection
