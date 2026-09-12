let FilePond;
let previewPluginsLoaded = false;
let previewPluginsRegistered = false;

async function loadCore() {
    if (!FilePond) {
        const module = await import("filepond");
        FilePond = module.default;

        await import("filepond/dist/filepond.min.css");
        await import("./filepond-custom.css");
    }
    return FilePond;
}

// Plugin preview+crop cuma di-load kalau benar-benar dipakai (initFilePondPreview),
// supaya field upload simpel (initFilePond biasa) tidak ikut menanggung bundle
// plugin-plugin ini kalau tidak perlu.
async function loadPreviewPlugins() {
    await loadCore();

    if (!previewPluginsLoaded) {
        const [
            fileValidateTypeModule,
            imageExifOrientationModule,
            imagePreviewModule,
            imageCropModule,
        ] = await Promise.all([
            import("filepond-plugin-file-validate-type"),
            import("filepond-plugin-image-exif-orientation"),
            import("filepond-plugin-image-preview"),
            import("filepond-plugin-image-crop"),
        ]);

        await import("filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css");

        if (!previewPluginsRegistered) {
            FilePond.registerPlugin(
                fileValidateTypeModule.default,
                imageExifOrientationModule.default,
                imagePreviewModule.default,
                imageCropModule.default
            );
            previewPluginsRegistered = true;
        }

        previewPluginsLoaded = true;
    }
}

const defaultLabel = `
    <div class="fp-aesthetic-wrapper">
        <div class="fp-icon-float">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/>
    <path d="M12 12v9"/>
    <path d="m16 16-4-4-4 4"/>
</svg>
        </div>
        <div class="fp-text-area">
            <span class="fp-title">
                <span class="filepond--label-action">Pilih file</span> atau seret ke sini
            </span>
        </div>
    </div>
`;

// Upload biasa, tanpa preview gambar/crop - dipakai lewat class "filepond".
// Mendukung single ATAU multi-file (tambahkan atribut `multiple` di <input> + `data-max-files`).
// Untuk mode Edit yang sudah punya file tersimpan, isi:
//   data-existing-files='[{"id":1,"url":"...","name":"video.mp4"}, ...]'
//   data-delete-existing-url-base="/penawaran/12/media"   (id di-append otomatis lewat JS)
// File yang sudah tersimpan dihapus LANGSUNG (AJAX) begitu diklik (x) - bukan ditunda
// sampai submit, sama seperti pola galeri foto (Dropzone).
export async function initFilePond(el, options = {}) {
    await loadCore();

    const existingFiles = el.dataset.existingFiles ? JSON.parse(el.dataset.existingFiles) : [];
    const deleteExistingUrlBase = el.dataset.deleteExistingUrlBase || null;
    const maxFiles = el.dataset.maxFiles ? parseInt(el.dataset.maxFiles, 10) : null;

    const files = existingFiles.map((item) => ({
        source: item.url,
        options: {
            type: 'local',
            file: { name: item.name, size: item.size || 0 },
            metadata: { existingId: item.id },
        },
    }));

    const pond = FilePond.create(el, {
        labelIdle: defaultLabel,
        allowProcess: false,
        // storeAsFile: penting untuk mode "tanpa server" ini - supaya file yang
        // dipilih/di-drop disimpan balik sebagai File object biasa ke <input> aslinya,
        // sehingga ikut terkirim wajar lewat <form> normal saat disubmit.
        // allowProcess:false saja TIDAK cukup - itu cuma mematikan auto-upload AJAX-nya,
        // tapi tanpa storeAsFile, input aslinya tidak otomatis terisi file-nya.
        storeAsFile: true,
        credits: false,
        files: files.length ? files : undefined,
        maxFiles: maxFiles || null,
        // server.load dipakai FilePond utk menampilkan file existing (source berupa URL)
        // sebagai preview - TIDAK terkait allowProcess/storeAsFile (itu ngatur upload KELUAR).
        server: files.length ? {
            load: (source, load, error, progress, abort) => {
                fetch(source)
                    .then((res) => {
                        if (!res.ok) throw new Error('Gagal memuat file yang sudah ada');
                        return res.blob();
                    })
                    .then(load)
                    .catch(error);
                return { abort: () => abort() };
            },
        } : undefined,
        onremovefile: (error, file) => {
            if (error) return;
            const existingId = file.getMetadata('existingId');
            if (existingId && deleteExistingUrlBase) {
                fetch(deleteExistingUrlBase + '/' + existingId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        Accept: 'application/json',
                    },
                });
            }
        },
        ...options,
    });

    // Penanda khusus versi biasa, supaya CSS-nya (fp-plain-root) tidak pernah
    // nyasar ke versi lingkaran (fp-circle-wrapper) walau dipakai bareng di 1 form.
    pond.element.classList.add('fp-plain-root');

    return pond;
}

// Upload dengan preview gambar + crop framing - dipakai lewat class "filepond-preview".
// Cara pakai (lihat INTEGRASI terkait untuk detail):
// <input type="file" class="filepond-preview" accept="image/jpeg,image/png,image/webp"
//     data-aspect-ratio="1:1" data-preview-height="170">
export async function initFilePondPreview(el, options = {}) {
    await loadPreviewPlugins();

    const acceptedFileTypes = el.getAttribute('accept')
        ? el.getAttribute('accept').split(',').map((t) => t.trim()).filter(Boolean)
        : ['image/jpeg', 'image/png', 'image/webp'];

    const imagePreviewHeight = Number(el.dataset.previewHeight) || 170;
    const stylePanelLayout = el.dataset.panelLayout || 'compact circle';

    // PENTING: layout "compact circle" diameternya ngikutin LEBAR PARENT elemen
    // (root FilePond punya CSS bawaan width:100%), BUKAN ngikutin imagePreviewHeight.
    // Kalau input-nya ditaruh di kolom form yang lebar, lingkarannya ikut melebar.
    // Cara paling andal: bungkus input dengan <div> berlebar tetap SEBELUM FilePond
    // dibuat - menimpa style root-nya SETELAH dibuat kurang bisa diandalkan karena
    // FilePond sendiri suka menghitung ulang & menimpa balik gaya root-nya.
    //
    // Dipisah jadi 2 lapis div bersarang:
    // - fp-circle-wrapper (luar): border + box-shadow + animasi hover. TIDAK overflow:hidden.
    // - fp-circle-clip (dalam): overflow:hidden + border-radius, TIDAK dianimasikan sama sekali.
    // Kalau digabung jadi 1 elemen, browser (terutama Chrome) suka glitch render pas
    // box-shadow-nya dianimasikan bareng overflow:hidden+border-radius - kelihatan
    // seperti ada celah/gap yang muncul-hilang pas hover. Dipisah gini lebih stabil.
    let wrapper = null;
    if (stylePanelLayout.includes('circle') && options.skipAutoWidth !== true) {
        wrapper = document.createElement('div');
        wrapper.className = 'fp-circle-wrapper';
        wrapper.style.width = `${imagePreviewHeight}px`;
        wrapper.style.height = `${imagePreviewHeight}px`;
        wrapper.style.maxWidth = '100%';
        wrapper.style.margin = '0 auto';

        const clip = document.createElement('div');
        clip.className = 'fp-circle-clip';

        el.parentNode.insertBefore(wrapper, el);
        wrapper.appendChild(clip);
        clip.appendChild(el);
    }

    // BARU: preload foto yang sudah ada (dipakai di halaman Edit) lewat atribut
    // data-existing-url. FilePond butuh fungsi server.load kecil untuk bisa menampilkan
    // file yang sumbernya URL (bukan File object baru) sebagai preview - ini TIDAK
    // terkait dengan allowProcess/storeAsFile (itu buat upload keluar), jadi aman
    // dipakai bareng tanpa mengaktifkan AJAX upload otomatis.
    const existingUrl = el.dataset.existingUrl || null;

    const pond = FilePond.create(el, {
        acceptedFileTypes,
        labelFileTypeNotAllowed: 'Format file tidak didukung',
        fileValidateTypeLabelExpectedTypes: 'Harus jpg, png atau webp',
        labelIdle: 'Drag & Drop foto kamu atau <span class="filepond--label-action">Pilih File</span>',
        imagePreviewHeight,
        imageCropAspectRatio: el.dataset.aspectRatio || '1:1',
        stylePanelLayout,
        styleLoadIndicatorPosition: 'center bottom',
        styleProgressIndicatorPosition: 'right bottom',
        styleButtonRemoveItemPosition: 'center bottom',
        styleButtonProcessItemPosition: 'right bottom',
        allowProcess: false,
        storeAsFile: true,
        credits: false,
        files: existingUrl ? [{ source: existingUrl, options: { type: 'local' } }] : [],
        server: existingUrl ? {
            load: (source, load, error, progress, abort) => {
                fetch(source)
                    .then((res) => {
                        if (!res.ok) throw new Error('Gagal memuat foto yang sudah ada');
                        return res.blob();
                    })
                    .then(load)
                    .catch(error);
                return { abort: () => abort() };
            },
        } : null,
        ...options,
    });
    return pond;
}
