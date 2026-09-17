@php
    $isEdit = isset($penawaran);
    $sizeRows = $isEdit ? $penawaran->rincianSize : collect();
    $biayaRows = $isEdit ? $penawaran->biayaHpp : collect();
@endphp

<form method="POST" action="{{ $isEdit ? route('penawaran.update', $penawaran) : route('penawaran.store') }}" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="form-group">
        <label>Judul <span class="text-danger">*</span></label>
        <input type="text" name="judul" value="{{ old('judul', $isEdit ? $penawaran->judul : '') }}" class="form-control @error('judul') is-invalid @enderror" placeholder="mis. Surplus Gurita Berbagai Size - Cabang Medan">
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-4 }} form-group">
            <label>Tipe <span class="text-danger">*</span></label>
            <select name="tipe" id="tipe" class="form-control selectric @error('tipe') is-invalid @enderror">
                @unless ($isEdit)
                    <option value="">-- Pilih Tipe --</option>
                @endunless
                <option value="Lokal" @selected(old('tipe', $isEdit ? $penawaran->tipe : null) == 'Lokal')>Lokal</option>
                <option value="Ekspor" @selected(old('tipe', $isEdit ? $penawaran->tipe : null) == 'Ekspor')>Ekspor</option>
                <option value="Ekspor & Lokal" @selected(old('tipe', $isEdit ? $penawaran->tipe : null) == 'Ekspor & Lokal')>Ekspor & Lokal</option>
            </select>
            @error('tipe')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4 }} form-group">
            <label>Jenis Penawaran <span class="text-danger">*</span></label>
            <select name="jenis_penawaran" id="jenis_penawaran" class="form-control selectric @error('jenis_penawaran') is-invalid @enderror">
                <option value="Produksi Sendiri" @selected(old('jenis_penawaran', $isEdit ? $penawaran->jenis_penawaran : null) == 'Produksi Sendiri')>Produksi Sendiri</option>
                <option value="Trading" @selected(old('jenis_penawaran', $isEdit ? $penawaran->jenis_penawaran : null) == 'Trading')>Trading / Beli Jadi dari Mitra</option>
            </select>
            @error('jenis_penawaran')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-4 }} form-group">
            <label>Kondisi Ikan</label>
            <input type="text" name="kondisi_ikan" value="{{ old('kondisi_ikan', $isEdit ? $penawaran->kondisi_ikan : '') }}" class="form-control" placeholder="Segar / Beku">
            @error('kondisi_ikan')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        @if ($isEdit)
            <div class="col-md-4 form-group">
                <label>Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control selectric">
                    <option value="tersedia" @selected($penawaran->status == 'tersedia')>Tersedia</option>
                    <option value="selesai" @selected($penawaran->status == 'selesai')>Selesai</option>
                    <option value="tutup" @selected($penawaran->status == 'tutup')>Tutup</option>
                </select>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label>Komoditi <span class="text-danger">*</span></label>
            <select name="komoditi_id" id="komoditi_id" class="form-control select2 @error('komoditi_id') is-invalid @enderror" @unless ($isEdit) data-placeholder="-- Pilih Komoditi --" @endunless>
                @unless ($isEdit)
                    <option value=""></option>
                @endunless
                @foreach ($komoditiList as $kategori => $daftar)
                    <optgroup label="{{ $kategori ?? 'Lainnya' }}">
                        @foreach ($daftar as $k)
                            <option value="{{ $k->id }}" @selected(old('komoditi_id', $isEdit ? $penawaran->komoditi_id : null) == $k->id)>{{ $k->nama }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('komoditi_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                Tidak menemukan komoditi yang dicari?
                <a href="{{ route('komoditi.usulkan') }}" target="_blank">Usulkan komoditi baru</a>.
            </small>
        </div>
        <div class="col-md-12 form-group">
            <label>Nama Ikan Lainnya</label>
            <select name="nama_ikan_lainnya[]" id="nama_ikan_lainnya" class="form-control select2-tags" multiple></select>
            @error('nama_ikan_lainnya.*')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted" id="hint-nama-ikan-lainnya">
                Otomatis terisi nama lain komoditi yang sudah tercatat. Ketik untuk menambah yang
                baru (mis. nama daerah/lokal) - langsung tersimpan begitu form ini disimpan, tanpa
                perlu ke halaman
                <a href="#" id="link-nama-daerah" target="_blank" class="disabled" style="pointer-events:none; opacity:.5;">Kelola Nama Ikan Lainnya</a>.
            </small>
        </div>
    </div>



    <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $isEdit ? $penawaran->keterangan : '') }}</textarea>
    </div>

    <!-- Rincian Size - baris bisa ditambah/hapus -->
    <div class="card card-body bg-light mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Rincian Size</h4>
            <button type="button" id="tambah-baris" class="btn btn-sm btn-info">
                <i class="fas fa-plus"></i> Tambah Baris
            </button>
        </div>
        <div class="text-muted small mb-2" id="hint-size">
            @if ($isEdit)
                Tidak menemukan size yang dicari?
                <a href="{{ route('komoditi.size.usulkan', $penawaran->komoditi_id) }}" id="link-usulkan-size" target="_blank">Usulkan size baru</a>.
            @else
                Pilih Komoditi terlebih dahulu supaya daftar size-nya muncul di sini.
                Tidak menemukan size yang dicari? <a href="#" id="link-usulkan-size" target="_blank">Usulkan size baru</a>.
            @endif
        </div>

        <div id="baris-size-container">
            @forelse ($sizeRows as $rincian)
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
            @empty
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
            @endforelse
        </div>
    </div>

    <!-- Rincian Biaya HPP / Margin - WAJIB diisi, label berubah sesuai Jenis Penawaran -->
    <div class="card card-body bg-light mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0" id="judul-section-biaya">Rincian Biaya HPP <span class="text-danger">*</span></h4>
            <button type="button" id="tambah-baris-biaya" class="btn btn-sm btn-info">
                <i class="fas fa-plus"></i> Tambah Biaya
            </button>
        </div>
        <div class="text-muted small mb-2" id="hint-section-biaya">
            Biaya operasional per kg (proses, packing, listrik, tenaga kerja, pengiriman, asuransi,
            dll) — berlaku SAMA untuk semua size di atas, dan otomatis ditambahkan ke harga beli
            saat dihitung sebagai Harga Jual. Wajib diisi minimal 1 baris.
        </div>

        <div id="baris-biaya-container">
            @forelse ($biayaRows as $biaya)
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
                <input type="text" name="sertifikasi" value="{{ old('sertifikasi', $isEdit ? $penawaran->detailEkspor->sertifikasi ?? '' : '') }}" class="form-control" placeholder="mis. HACCP">
            </div>
            <div class="col-md-4 form-group">
                <label>Kontinuitas Suplai</label>
                <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai', $isEdit ? $penawaran->detailEkspor->kontinuitas_suplai ?? '' : '') }}" class="form-control" placeholder="Self-declare, mis. 'Rutin tiap minggu'">
            </div>
            <div class="col-md-4 form-group">
                <label>Negara Tujuan</label>
                <input type="text" name="negara_tujuan" value="{{ old('negara_tujuan', $isEdit ? $penawaran->detailEkspor->negara_tujuan ?? '' : '') }}" class="form-control">
            </div>
        </div>
    </div>

    <!-- Galeri Foto & Video - sengaja ditaruh paling bawah, setelah Detail Ekspor -->
    <div class="card card-body bg-light mb-3">
        <h4 class="mb-3">Galeri Foto</h4>
        <x-dropzone-gallery name="foto_gallery" context="foto" :existing-media="$isEdit ? $penawaran->getMedia('foto') : null" :upload-route="route('mediaTemp.upload')" :delete-temp-route="route('mediaTemp.delete')" :delete-existing-url-base="$isEdit ? url('/penawaran/' . $penawaran->id . '/media') : null" accepted-files="image/jpeg,image/png,image/webp" />
        <small class="form-text text-muted">Format JPG/PNG/WEBP, maksimal 5 MB per foto. Jumlah bebas.</small>
    </div>

    <div class="card card-body bg-light mb-3">
        <h4 class="mb-3">Video <span class="text-muted font-weight-normal">(maks 2)</span></h4>
        <input type="file" name="video[]" class="filepond" multiple accept="video/mp4,video/quicktime,video/webm" data-max-files="2" @if ($isEdit) data-existing-files='{{ $penawaran->getMedia('video')->map(fn($m) => ['id' => $m->id, 'url' => $m->getUrl(), 'name' => $m->file_name, 'size' => $m->size])->values()->toJson() }}'
                data-delete-existing-url-base="{{ url('/penawaran/' . $penawaran->id . '/media') }}" @endif>
        <small class="form-text text-muted">Format MP4/MOV/WEBM, maksimal 50 MB per video, maksimal 2 video.</small>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('penawaran.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
        @if ($isEdit)
            <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Simpan Perubahan</button>
        @else
            <button type="submit" class="btn btn-info"><i class="fas fa-plus"></i> Simpan Penawaran</button>
        @endif
    </div>
</form>

@section('scripts')
    <script>
        // Peta komoditi_id => daftar size disetujui miliknya (dari server).
        const sizesByKomoditi = {!! $sizesByKomoditi !!};
        // Peta komoditi_id => daftar nama lain (tag) yang sudah tercatat (dari server).
        const tagsByKomoditi = {!! $tagsByKomoditi !!};

        document.addEventListener('DOMContentLoaded', function() {
            const dataCard = document.getElementById('card-data');

            function showKomoditiLoading(task) {
                if (!dataCard || typeof window.cardProgress !== 'function') {
                    task();
                    return;
                }

                window.cardProgress(dataCard, {
                    dismiss: false
                });
                window.setTimeout(() => {
                    try {
                        task();
                    } finally {
                        window.cardProgressDismiss(dataCard);
                    }
                }, 180);
            }

            // Dibungkus function + try/catch sendiri, supaya kalau ada error di bagian
            // ini, bagian LAIN di bawah (dropdown size, tambah/hapus baris, dst) tetap
            // jalan normal - tidak ikut mati gara-gara satu bagian gagal.
            (function initToggleFieldEkspor() {
                const tipeSelect = document.getElementById('tipe');
                const fieldEkspor = document.getElementById('field-ekspor');
                if (!tipeSelect || !fieldEkspor) return;

                function toggleFieldEkspor() {
                    const val = tipeSelect.value;
                    fieldEkspor.style.display = (val === 'Ekspor' || val === 'Ekspor & Lokal') ? 'block' : 'none';
                }

                // Selectric SEHARUSNYA meneruskan event 'change' ke <select> aslinya, tapi
                // supaya tidak bergantung 100% ke itu, didengarkan lewat DUA jalur sekaligus:
                // vanilla JS (native) DAN jQuery (in case Selectric memicu lewat jQuery).
                tipeSelect.addEventListener('change', toggleFieldEkspor);
                if (window.jQuery) {
                    window.jQuery(tipeSelect).on('change', toggleFieldEkspor);
                }

                toggleFieldEkspor();
            })();

            // toggle label section biaya berdasarkan Jenis Penawaran (Produksi Sendiri vs Trading)
            (function initToggleLabelBiaya() {
                const jenisPenawaranSelect = document.getElementById('jenis_penawaran');
                const judulSectionBiaya = document.getElementById('judul-section-biaya');
                const hintSectionBiaya = document.getElementById('hint-section-biaya');
                const contohSectionBiaya = document.getElementById('contoh-section-biaya');
                if (!jenisPenawaranSelect || !judulSectionBiaya || !hintSectionBiaya || !contohSectionBiaya) return;

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

                // Sama seperti toggle Tipe/Ekspor - didengarkan lewat 2 jalur (native + jQuery)
                // supaya tidak bergantung 100% ke cara Selectric meneruskan event 'change'.
                jenisPenawaranSelect.addEventListener('change', toggleLabelBiaya);
                if (window.jQuery) {
                    window.jQuery(jenisPenawaranSelect).on('change', toggleLabelBiaya);
                }

                toggleLabelBiaya();
            })();

            // ---- Dropdown size, cascading berdasarkan Komoditi yang dipilih ----
            const komoditiSelect = document.getElementById('komoditi_id');
            const hintSize = document.getElementById('hint-size');
            const tambahBarisBtn = document.getElementById('tambah-baris');

            // pertahankanNilaiLama: dipakai waktu load pertama di form Edit (atau form Create
            // yang muncul lagi karena validasi gagal) - supaya baris yang sudah punya
            // data-selected tidak kehilangan pilihan size-nya.
            function isiDropdownSize(selectEl, komoditiId, pertahankanNilaiLama) {
                const nilaiTerpilih = pertahankanNilaiLama ? selectEl.dataset.selected : '';
                const daftar = sizesByKomoditi[komoditiId] || [];
                selectEl.innerHTML = '';

                if (!komoditiId || daftar.length === 0) {
                    selectEl.innerHTML = '<option value="">-- ' + (komoditiId ? 'Belum ada size untuk komoditi ini' : 'Pilih Komoditi dulu') + ' --</option>';
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

                const linkUsulkanSize = document.getElementById('link-usulkan-size');
                if (komoditiId) {
                    hintSize.innerHTML = 'Tidak menemukan size yang dicari? <a href="/komoditi/' + komoditiId + '/size/usulkan" id="link-usulkan-size" target="_blank">Usulkan size baru</a>.';
                } else {
                    hintSize.textContent = 'Pilih Komoditi terlebih dahulu supaya daftar size-nya muncul di sini.';
                }

                tambahBarisBtn.disabled = !(sizesByKomoditi[komoditiId] && sizesByKomoditi[komoditiId].length);

                perbaruiLinkNamaDaerah(komoditiId);
                perbaruiNamaIkanLainnya(komoditiId);
            }

            // Link "Kelola Nama Ikan Lainnya" ikut menyesuaikan komoditi yang dipilih.
            function perbaruiLinkNamaDaerah(komoditiId) {
                const link = document.getElementById('link-nama-daerah');
                if (!link) return;

                if (komoditiId) {
                    link.href = '/komoditi/' + komoditiId + '/tag';
                    link.textContent = 'Kelola Nama Ikan Lainnya';
                    link.classList.remove('disabled');
                    link.style.pointerEvents = '';
                    link.style.opacity = '';
                } else {
                    link.href = '#';
                    link.textContent = 'Kelola Nama Ikan Lainnya';
                    link.classList.add('disabled');
                    link.style.pointerEvents = 'none';
                    link.style.opacity = '.5';
                }
            }

            // Select2 "Nama Ikan Lainnya" - diisi ulang dengan nama-nama yang SUDAH tercatat
            // untuk komoditi terpilih (semuanya langsung ke-select, sebagai info + supaya
            // gampang dihapus kalau memang mau tidak disertakan). User tetap bisa MENGETIK
            // nama baru (select2 tags:true) - itu yang nanti disimpan sebagai tag baru saat
            // form disubmit (lihat SavesKomoditiTags di backend).
            function perbaruiNamaIkanLainnya(komoditiId) {
                const namaIkanSelect = document.getElementById('nama_ikan_lainnya');
                if (!namaIkanSelect || !window.jQuery) return;

                const $select = window.jQuery(namaIkanSelect);
                $select.empty();

                (tagsByKomoditi[komoditiId] || []).forEach((tag) => {
                    $select.append(new Option(tag, tag, true, true));
                });

                $select.trigger('change');
            }

            // Load pertama: pertahankan size yang sudah tersimpan (baris Edit, atau baris
            // Create yang muncul lagi karena validasi gagal).
            perbaruiSemuaDropdownSize(true);

            // Kalau Komoditi diganti manual: tampilkan loading saat size/tag di-refresh,
            // lalu lanjutkan update dropdown dan tag yang terkait.
            komoditiSelect.addEventListener('change', () => {
                showKomoditiLoading(() => perbaruiSemuaDropdownSize(false));
            });
            $(komoditiSelect).on('select2:select select2:clear', () => {
                showKomoditiLoading(() => perbaruiSemuaDropdownSize(false));
            });

            // tambah/hapus baris rincian size
            const container = document.getElementById('baris-size-container');
            tambahBarisBtn.addEventListener('click', function() {
                const baris = container.querySelector('.baris-size').cloneNode(true);
                baris.querySelectorAll('input').forEach(input => input.value = '');
                isiDropdownSize(baris.querySelector('.komoditi-size-select'), komoditiSelect.value, false);
                baris.querySelector('.hapus-baris').style.display = 'inline-block';
                container.appendChild(baris);
                perbaruiTombolHapus();
            });

            container.addEventListener('click', function(e) {
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

            // tambah/hapus baris biaya HPP - pola sama dengan rincian size
            const containerBiaya = document.getElementById('baris-biaya-container');
            document.getElementById('tambah-baris-biaya').addEventListener('click', function() {
                const baris = containerBiaya.querySelector('.baris-biaya').cloneNode(true);
                baris.querySelectorAll('input').forEach(input => input.value = '');
                baris.querySelector('.hapus-baris-biaya').style.display = 'inline-block';
                containerBiaya.appendChild(baris);
                perbaruiTombolHapusBiaya();
            });

            containerBiaya.addEventListener('click', function(e) {
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
