@extends('layouts.app')

@section('title', 'Tambah Penawaran')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('penawaran.store') }}">
            @csrf

            <div class="form-group">
                <label>Judul <span class="text-danger">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control @error('judul') is-invalid @enderror" placeholder="mis. Surplus Gurita Berbagai Size - Cabang Medan">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label>Tipe <span class="text-danger">*</span></label>
                    <select name="tipe" id="tipe" class="form-control selectric @error('tipe') is-invalid @enderror">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Lokal" @selected(old('tipe')=='Lokal')>Lokal</option>
                        <option value="Ekspor" @selected(old('tipe')=='Ekspor')>Ekspor</option>
                        <option value="Ekspor & Lokal" @selected(old('tipe')=='Ekspor & Lokal')>Ekspor & Lokal</option>
                    </select>
                    @error('tipe') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 form-group">
                    <label>Jenis Penawaran <span class="text-danger">*</span></label>
                    <select name="jenis_penawaran" id="jenis_penawaran" class="form-control selectric @error('jenis_penawaran') is-invalid @enderror">
                        <option value="Produksi Sendiri" @selected(old('jenis_penawaran')=='Produksi Sendiri')>Produksi Sendiri</option>
                        <option value="Trading" @selected(old('jenis_penawaran')=='Trading')>Trading / Beli Jadi dari Mitra</option>
                    </select>
                    @error('jenis_penawaran') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 form-group">
                    <label>Komoditi <span class="text-danger">*</span></label>
                    <select name="komoditi_id" id="komoditi_id" class="form-control select2 @error('komoditi_id') is-invalid @enderror" data-placeholder="-- Pilih Komoditi --">
                        <option value=""></option>
                        @foreach ($komoditiList as $kategori => $daftar)
                            <optgroup label="{{ $kategori ?? 'Lainnya' }}">
                                @foreach ($daftar as $k)
                                    <option value="{{ $k->id }}" @selected(old('komoditi_id')==$k->id)>{{ $k->nama }}{{ $k->tags->isNotEmpty() ? ' (' . $k->tags->pluck('nama_tag')->implode(', ') . ')' : '' }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('komoditi_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <small class="form-text text-muted">
                        Tidak menemukan komoditi yang dicari?
                        <a href="{{ route('komoditi.usulkan') }}" target="_blank">Usulkan komoditi baru</a>
                        &middot; atau mungkin sudah ada dengan nama daerah lain -
                        <a href="#" id="link-nama-daerah" target="_blank" class="disabled" style="pointer-events:none; opacity:.5;">pilih komoditi dulu</a>
                    </small>
                </div>
            </div>

            <div class="form-group">
                <label>Kondisi Ikan</label>
                <input type="text" name="kondisi_ikan" value="{{ old('kondisi_ikan') }}" class="form-control" placeholder="Segar / Beku">
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
            </div>

            <!-- Rincian Size - baris bisa ditambah/hapus -->
            <div class="card card-body bg-light mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Rincian Size</h4>
                    <button type="button" id="tambah-baris" class="btn btn-sm btn-primary" disabled>
                        <i class="fas fa-plus"></i> Tambah Baris
                    </button>
                </div>
                <div class="text-muted small mb-2" id="hint-size">
                    Pilih Komoditi terlebih dahulu supaya daftar size-nya muncul di sini.
                    Tidak menemukan size yang dicari? <a href="#" id="link-usulkan-size" target="_blank">Usulkan size baru</a>.
                </div>

                <div id="baris-size-container">
                    <div class="row baris-size mb-2">
                        <div class="col-md-5">
                            <select name="komoditi_size_id[]" class="form-control komoditi-size-select" required disabled>
                                <option value="">-- Pilih Komoditi dulu --</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="harga[]" class="form-control" placeholder="Harga Beli / kg (bahan baku)" required>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="kuantiti[]" class="form-control" placeholder="Kuantiti (kg)" required>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger hapus-baris" style="display:none;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
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
                    Biaya operasional per kg (proses, packing, listrik, tenaga kerja, pengiriman, asuransi,
                    dll) — berlaku SAMA untuk semua size di atas, dan otomatis ditambahkan ke harga beli
                    saat dihitung sebagai Harga Jual. Wajib diisi minimal 1 baris.
                </div>

                <div id="baris-biaya-container">
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
                </div>
                <div class="text-muted small mt-2" id="contoh-section-biaya">
                    Contoh label: Biaya Proses, Biaya Packing, Biaya Listrik, Biaya Tenaga Kerja,
                    Biaya Pengiriman, Asuransi, atau biaya lain sesuai komoditi Anda.
                </div>
            </div>

            <!-- Field ekspor - muncul dinamis jika tipe mengandung "Ekspor" -->
            <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
                <h4 class="mb-3">Detail Ekspor</h4>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Sertifikasi</label>
                        <input type="text" name="sertifikasi" value="{{ old('sertifikasi') }}" class="form-control" placeholder="mis. HACCP">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Kontinuitas Suplai</label>
                        <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai') }}" class="form-control" placeholder="Self-declare, mis. 'Rutin tiap minggu'">
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Negara Tujuan</label>
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
    // Peta komoditi_id => daftar size disetujui miliknya (dari server).
    const sizesByKomoditi = {!! $sizesByKomoditi !!};

    document.addEventListener('DOMContentLoaded', function () {
        // toggle field ekspor
        const tipeSelect = document.getElementById('tipe');
        const fieldEkspor = document.getElementById('field-ekspor');
        function toggleFieldEkspor() {
            const val = tipeSelect.value;
            fieldEkspor.style.display = (val === 'Ekspor' || val === 'Ekspor & Lokal') ? 'block' : 'none';
        }
        tipeSelect.addEventListener('change', toggleFieldEkspor);
        toggleFieldEkspor();

        // toggle label section biaya berdasarkan Jenis Penawaran (Produksi Sendiri vs Trading)
        const jenisPenawaranSelect = document.getElementById('jenis_penawaran');
        const judulSectionBiaya = document.getElementById('judul-section-biaya');
        const hintSectionBiaya = document.getElementById('hint-section-biaya');
        const contohSectionBiaya = document.getElementById('contoh-section-biaya');

        function toggleLabelBiaya() {
            if (jenisPenawaranSelect.value === 'Trading') {
                judulSectionBiaya.innerHTML = 'Margin / Keuntungan <span class="text-danger">*</span>';
                hintSectionBiaya.textContent = 'Karena barang sudah jadi dari mitra (biaya proses/packing/dll sudah ditanggung mitra), cukup isi margin/keuntungan yang Anda inginkan per kg. Wajib diisi minimal 1 baris.';
                contohSectionBiaya.textContent = 'Contoh label: Margin/Keuntungan, atau biaya tambahan lain jika ada (mis. Transport dari Mitra).';
            } else {
                judulSectionBiaya.innerHTML = 'Rincian Biaya HPP <span class="text-danger">*</span>';
                hintSectionBiaya.textContent = 'Biaya operasional per kg (proses, packing, listrik, tenaga kerja, pengiriman, asuransi, dll) — berlaku SAMA untuk semua size di atas, dan otomatis ditambahkan ke harga beli saat dihitung sebagai Harga Jual. Wajib diisi minimal 1 baris.';
                contohSectionBiaya.textContent = 'Contoh label: Biaya Proses, Biaya Packing, Biaya Listrik, Biaya Tenaga Kerja, Biaya Pengiriman, Asuransi, atau biaya lain sesuai komoditi Anda.';
            }
        }
        jenisPenawaranSelect.addEventListener('change', toggleLabelBiaya);
        toggleLabelBiaya();

        // ---- Dropdown size, cascading berdasarkan Komoditi yang dipilih ----
        const komoditiSelect = document.getElementById('komoditi_id');
        const hintSize = document.getElementById('hint-size');
        const tambahBarisBtn = document.getElementById('tambah-baris');
        const linkUsulkanSize = document.getElementById('link-usulkan-size');

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
                hintSize.innerHTML = 'Tidak menemukan size yang dicari? <a href="/komoditi/' + komoditiId + '/size/usulkan" id="link-usulkan-size" target="_blank">Usulkan size baru</a>.';
                tambahBarisBtn.disabled = !(sizesByKomoditi[komoditiId] && sizesByKomoditi[komoditiId].length);
            } else {
                hintSize.textContent = 'Pilih Komoditi terlebih dahulu supaya daftar size-nya muncul di sini.';
                tambahBarisBtn.disabled = true;
            }

            perbaruiLinkNamaDaerah(komoditiId);
        }

        // Link "nama daerah" ikut menyesuaikan komoditi yang dipilih.
        function perbaruiLinkNamaDaerah(komoditiId) {
            const link = document.getElementById('link-nama-daerah');
            if (!link) return;

            if (komoditiId) {
                link.href = '/komoditi/' + komoditiId + '/tag';
                link.textContent = 'kelola nama daerah komoditi ini';
                link.classList.remove('disabled');
                link.style.pointerEvents = '';
                link.style.opacity = '';
            } else {
                link.href = '#';
                link.textContent = 'pilih komoditi dulu';
                link.classList.add('disabled');
                link.style.pointerEvents = 'none';
                link.style.opacity = '.5';
            }
        }

        komoditiSelect.addEventListener('change', perbaruiSemuaDropdownSize);
        // select2 mengganti event asli, jadi ikut dengarkan event bawaan select2 juga
        $(komoditiSelect).on('select2:select select2:clear', perbaruiSemuaDropdownSize);

        // Kalau form ini muncul lagi karena validasi gagal dan Komoditi sudah sempat
        // dipilih, langsung isi dropdown size baris pertama (baris tambahan tidak
        // otomatis dipulihkan - keterbatasan wajar untuk dropdown yang sifatnya dinamis).
        if (komoditiSelect.value) {
            perbaruiSemuaDropdownSize();
        } else {
            perbaruiLinkNamaDaerah('');
        }

        // tambah/hapus baris rincian size
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

        // tambah/hapus baris biaya HPP - pola sama dengan rincian size
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
    });
</script>
@endsection
