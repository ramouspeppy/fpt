@php
    $isEdit = isset($permintaan);
    $sizeRows = $isEdit ? $permintaan->rincianSize : collect();
@endphp

<form method="POST" action="{{ $isEdit ? route('permintaan.update', $permintaan) : route('permintaan.store') }}" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="form-group">
        <label>Judul <span class="text-danger">*</span></label>
        <input type="text" name="judul" value="{{ old('judul', $isEdit ? $permintaan->judul : '') }}"
            class="form-control @error('judul') is-invalid @enderror" placeholder="mis. Permintaan Gurita Ekspor - PT Sumber Laut Jaya">
        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="row">
        <div class="col-md-{{ $isEdit ? 4 : 6 }} form-group">
            <label>Tipe <span class="text-danger">*</span></label>
            <select name="tipe" id="tipe" class="form-control selectric @error('tipe') is-invalid @enderror">
                @unless ($isEdit)
                    <option value="">-- Pilih Tipe --</option>
                @endunless
                <option value="Lokal" @selected(old('tipe', $isEdit ? $permintaan->tipe : null)=='Lokal')>Lokal</option>
                <option value="Ekspor" @selected(old('tipe', $isEdit ? $permintaan->tipe : null)=='Ekspor')>Ekspor</option>
            </select>
            @error('tipe') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        @if ($isEdit)
            <div class="col-md-4 form-group">
                <label>Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control selectric">
                    <option value="tersedia" @selected($permintaan->status=='tersedia')>Tersedia</option>
                    <option value="selesai" @selected($permintaan->status=='selesai')>Selesai</option>
                    <option value="tutup" @selected($permintaan->status=='tutup')>Tutup</option>
                </select>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label>Komoditi <span class="text-danger">*</span></label>
            <select name="komoditi_id" id="komoditi_id" class="form-control select2 @error('komoditi_id') is-invalid @enderror"
                @unless ($isEdit) data-placeholder="-- Pilih Komoditi --" @endunless>
                @unless ($isEdit)
                    <option value=""></option>
                @endunless
                @foreach ($komoditiList as $kategori => $daftar)
                    <optgroup label="{{ $kategori ?? 'Lainnya' }}">
                        @foreach ($daftar as $k)
                            <option value="{{ $k->id }}" @selected(old('komoditi_id', $isEdit ? $permintaan->komoditi_id : null)==$k->id)>{{ $k->nama }}{{ $k->tags->isNotEmpty() ? ' (' . $k->tags->pluck('nama_tag')->implode(', ') . ')' : '' }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('komoditi_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            <small class="form-text text-muted">
                Tidak menemukan komoditi yang dicari?
                <a href="{{ route('komoditi.usulkan') }}" target="_blank">Usulkan komoditi baru</a>.
            </small>
        </div>
        <div class="col-md-6 form-group">
            <label>Nama Ikan Lainnya</label>
            <select name="nama_ikan_lainnya[]" id="nama_ikan_lainnya" class="form-control select2-tags" multiple
                data-placeholder="-- Pilih komoditi dulu, atau ketik nama lain --"></select>
            @error('nama_ikan_lainnya.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
        <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $isEdit ? $permintaan->keterangan : '') }}</textarea>
    </div>

    <!-- Rincian Size -->
    <div class="card card-body bg-light mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Rincian Size Dibutuhkan</h4>
            <button type="button" id="tambah-baris" class="btn btn-sm btn-info">
                <i class="fas fa-plus"></i> Tambah Baris
            </button>
        </div>
        <div class="text-muted small mb-2" id="hint-size">
            @if ($isEdit)
                Tidak menemukan size yang dicari?
                <a href="{{ route('komoditi.size.usulkan', $permintaan->komoditi_id) }}" id="link-usulkan-size" target="_blank">Usulkan size baru</a>.
            @else
                Pilih Komoditi terlebih dahulu supaya daftar size-nya muncul di sini.
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
                        <input type="number" step="0.01" name="harga[]" class="form-control" placeholder="Harga per kg" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="kuantiti[]" class="form-control" placeholder="Kuantiti dibutuhkan (kg)" required>
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
        <h4 class="mb-3">Indikator Prioritas @unless ($isEdit) (khusus tim Pusat) @endunless</h4>
        <div class="row">
            <div class="col-md-6 form-group">
                <label>Warna Prioritas</label>
                <select name="prioritas_warna" class="form-control selectric">
                    <option value="">-- Tidak ada --</option>
                    <option value="merah" @selected(old('prioritas_warna', $isEdit ? $permintaan->prioritas_warna : null)=='merah')>Merah (Urgent)</option>
                    <option value="kuning" @selected(old('prioritas_warna', $isEdit ? $permintaan->prioritas_warna : null)=='kuning')>Kuning (Biasa)</option>
                    <option value="hijau" @selected(old('prioritas_warna', $isEdit ? $permintaan->prioritas_warna : null)=='hijau')>Hijau (Tidak Mendesak)</option>
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label>Tag Konteks</label>
                <input type="text" name="prioritas_tag" value="{{ old('prioritas_tag', $isEdit ? $permintaan->prioritas_tag : '') }}"
                    class="form-control" placeholder="mis. Urgent - buyer nunggu 3 hari">
            </div>
        </div>
    </div>
    @endrole

    <div id="field-ekspor" class="card card-body bg-light mb-3" style="display:none;">
        <h4 class="mb-3">Detail Ekspor</h4>
        <div class="row">
            <div class="col-md-4 form-group">
                <label>Sertifikasi</label>
                <input type="text" name="sertifikasi" value="{{ old('sertifikasi', $isEdit ? ($permintaan->detailEkspor->sertifikasi ?? '') : '') }}" class="form-control" placeholder="mis. HACCP">
            </div>
            <div class="col-md-4 form-group">
                <label>Kontinuitas Suplai</label>
                <input type="text" name="kontinuitas_suplai" value="{{ old('kontinuitas_suplai', $isEdit ? ($permintaan->detailEkspor->kontinuitas_suplai ?? '') : '') }}" class="form-control">
            </div>
            <div class="col-md-4 form-group">
                <label>Negara Tujuan</label>
                <input type="text" name="negara_tujuan" value="{{ old('negara_tujuan', $isEdit ? ($permintaan->detailEkspor->negara_tujuan ?? '') : '') }}" class="form-control">
            </div>
        </div>
    </div>

    <!-- Galeri Foto & Video - sengaja ditaruh paling bawah, setelah Detail Ekspor -->
    <div class="card card-body bg-light mb-3">
        <h4 class="mb-3">Galeri Foto</h4>
        <x-dropzone-gallery
            name="foto_gallery"
            context="foto"
            :existing-media="$isEdit ? $permintaan->getMedia('foto') : null"
            :upload-route="route('mediaTemp.upload')"
            :delete-temp-route="route('mediaTemp.delete')"
            :delete-existing-url-base="$isEdit ? url('/permintaan/' . $permintaan->id . '/media') : null"
            accepted-files="image/jpeg,image/png,image/webp"
        />
        <small class="form-text text-muted">Format JPG/PNG/WEBP, maksimal 5 MB per foto. Jumlah bebas.</small>
    </div>

    <div class="card card-body bg-light mb-3">
        <h4 class="mb-3">Video <span class="text-muted font-weight-normal">(maks 2)</span></h4>
        <input type="file" name="video[]" class="filepond" multiple
            accept="video/mp4,video/quicktime,video/webm"
            data-max-files="2"
            @if ($isEdit)
                data-existing-files='{{ $permintaan->getMedia("video")->map(fn ($m) => ["id" => $m->id, "url" => $m->getUrl(), "name" => $m->file_name, "size" => $m->size])->values()->toJson() }}'
                data-delete-existing-url-base="{{ url('/permintaan/' . $permintaan->id . '/media') }}"
            @endif>
        <small class="form-text text-muted">Format MP4/MOV/WEBM, maksimal 50 MB per video, maksimal 2 video.</small>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('permintaan.index') }}" class="btn btn-light"><i class="fas fa-arrow-left"></i> Kembali</a>
        @if ($isEdit)
            <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Simpan Perubahan</button>
        @else
            <button type="submit" class="btn btn-info"><i class="fas fa-plus"></i> Simpan Permintaan</button>
        @endif
    </div>
</form>

@section('scripts')
<script>
    const sizesByKomoditi = {!! $sizesByKomoditi !!};
    const tagsByKomoditi = {!! $tagsByKomoditi !!};

    document.addEventListener('DOMContentLoaded', function () {
        // Dibungkus function + try/catch sendiri, supaya kalau ada error di bagian
        // ini, bagian LAIN di bawah (dropdown size, tambah/hapus baris, dst) tetap
        // jalan normal - tidak ikut mati gara-gara satu bagian gagal.
        (function initToggleFieldEkspor() {
            const tipeSelect = document.getElementById('tipe');
            const fieldEkspor = document.getElementById('field-ekspor');
            if (!tipeSelect || !fieldEkspor) return;

            function toggleFieldEkspor() {
                fieldEkspor.style.display = (tipeSelect.value === 'Ekspor') ? 'block' : 'none';
            }

            // Selectric (plugin dropdown custom utk field Tipe) SEHARUSNYA meneruskan
            // event 'change' ke <select> aslinya, tapi supaya tidak bergantung 100% ke
            // itu, event-nya didengarkan lewat DUA jalur sekaligus: vanilla JS (native)
            // DAN jQuery (in case Selectric memicu lewat jQuery, bukan native dispatch).
            tipeSelect.addEventListener('change', toggleFieldEkspor);
            if (window.jQuery) {
                window.jQuery(tipeSelect).on('change', toggleFieldEkspor);
            }

            toggleFieldEkspor();
        })();

        // BARU: loading overlay (my-card-progress.js, dimuat global di app.js) - kedip
        // sebentar tiap kali Tipe/Komoditi diganti, dan MENETAP + tombol Simpan
        // dinonaktifkan begitu form disubmit - supaya user tidak bisa klik dobel
        // kalau koneksinya lambat.
        (function initCardProgress() {
            const formEl = document.querySelector('form');
            if (!formEl || !window.cardProgress) return;
            const cardEl = formEl.closest('.card') || formEl;

            function kedipkanLoading() {
                window.cardProgress(cardEl);
                setTimeout(() => window.cardProgressDismiss(cardEl), 350);
            }

            ['tipe', 'komoditi_id'].forEach((id) => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('change', kedipkanLoading);
                if (window.jQuery) window.jQuery(el).on('change', kedipkanLoading);
            });

            formEl.addEventListener('submit', function () {
                window.cardProgress(cardEl);
                const submitBtn = formEl.querySelector('button[type="submit"]');
                if (submitBtn) submitBtn.disabled = true;
            });
        })();

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

            if (komoditiId) {
                hintSize.innerHTML = 'Tidak menemukan size yang dicari? <a href="/komoditi/' + komoditiId + '/size/usulkan" id="link-usulkan-size" target="_blank">Usulkan size baru</a>.';
            } else {
                hintSize.textContent = 'Pilih Komoditi terlebih dahulu supaya daftar size-nya muncul di sini.';
            }

            tambahBarisBtn.disabled = !(sizesByKomoditi[komoditiId] && sizesByKomoditi[komoditiId].length);

            perbaruiLinkNamaDaerah(komoditiId);
            perbaruiNamaIkanLainnya(komoditiId);
        }

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
        // untuk komoditi terpilih. User tetap bisa MENGETIK nama baru (select2 tags:true) -
        // itu yang nanti disimpan sebagai tag baru saat form disubmit (lihat
        // SavesKomoditiTags di backend).
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

        perbaruiSemuaDropdownSize(true);
        komoditiSelect.addEventListener('change', () => perbaruiSemuaDropdownSize(false));
        $(komoditiSelect).on('select2:select select2:clear', () => perbaruiSemuaDropdownSize(false));

        const container = document.getElementById('baris-size-container');
        tambahBarisBtn.addEventListener('click', function () {
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
    });
</script>
@endsection
