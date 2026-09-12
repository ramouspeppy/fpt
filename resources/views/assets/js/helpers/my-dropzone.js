let Dropzone;

async function loadDropzone() {
    if (!Dropzone) {
        const mod = await import('dropzone');

        // Package "dropzone" (v5.x) dibundel sebagai UMD - tergantung cara Vite
        // menginterop-kannya, constructor-nya bisa muncul di beberapa tempat berbeda.
        // Dicoba satu-satu sampai ketemu yang benar-benar berupa function/class.
        const kandidat = [mod.default, mod.default?.default, mod.Dropzone, mod];
        Dropzone = kandidat.find((k) => typeof k === 'function');

        if (!Dropzone) {
            throw new Error('Tidak menemukan constructor Dropzone dari package "dropzone". Cek instalasi npm.');
        }

        Dropzone.autoDiscover = false;

        await import('dropzone/dist/dropzone.css');
        await import('./dropzone-custom.css');
    }
    return Dropzone;
}

// Elemen dipasang di <div class="dropzone-gallery" data-...></div> (BUKAN di <input>,
// beda dengan pola FilePond). Atribut data- yang dibaca:
// - data-upload-url        endpoint upload temp (POST, field "file" + "context")
// - data-delete-temp-url   endpoint hapus temp (POST, {context, name})
// - data-delete-existing-url-base   dasar URL hapus media yang SUDAH tersimpan, id di-append di belakang (DELETE)
// - data-context           "foto" atau "video" (dikirim ke server utk validasi mime/size)
// - data-field-name        nama hidden input array, mis. "foto_gallery" / "video_gallery"
// - data-accepted-files    mis. "image/jpeg,image/png,image/webp"
// - data-max-files         batas total (termasuk yang sudah ada) - kosongkan utk tanpa batas
// - data-max-filesize-mb   default 5
// - data-existing          JSON array file: [{id,url,file_name,size,is_temp,temp_name}]
//                          is_temp:false -> media resmi (hapus via delete-existing-url-base)
//                          is_temp:true  -> file temp yg selamat dari validasi gagal (hapus via delete-temp-url)
// - data-preview-as-image  "1" kalau mau thumbnail asli (foto), kosongkan utk ikon generik (video)
export async function initDropzoneGallery(el) {
    await loadDropzone();

    const form = el.closest('form');
    const fieldName = el.dataset.fieldName;
    const context = el.dataset.context;
    const existing = el.dataset.existing ? JSON.parse(el.dataset.existing) : [];
    const previewAsImage = el.dataset.previewAsImage === '1';
    const maxFilesTotal = el.dataset.maxFiles ? parseInt(el.dataset.maxFiles, 10) : null;
    const sisaSlot = maxFilesTotal ? Math.max(0, maxFilesTotal - existing.length) : null;

    function tambahHiddenInput(value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = fieldName + '[]';
        input.value = value;
        input.dataset.tempFile = '1';
        form.appendChild(input);
        return input;
    }

    function hapusHiddenInput(value) {
        const input = form.querySelector('input[data-temp-file="1"][name="' + fieldName + '[]"][value="' + value + '"]');
        if (input) input.remove();
    }

    const dz = new Dropzone(el, {
        url: el.dataset.uploadUrl,
        paramName: 'file',
        params: { context: context },
        maxFilesize: parseFloat(el.dataset.maxFilesizeMb || '5'),
        acceptedFiles: el.dataset.acceptedFiles || undefined,
        maxFiles: sisaSlot,
        addRemoveLinks: true,
        dictRemoveFile: 'Hapus',
        dictMaxFilesExceeded: 'Sudah mencapai batas maksimal file.',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        init: function () {
            const dzInstance = this;

            existing.forEach(function (item) {
                const mockFile = {
                    name: item.file_name,
                    size: item.size || 0,
                    existingMediaId: item.is_temp ? null : item.id,
                    tempName: item.is_temp ? item.temp_name : null,
                    accepted: true,
                    status: Dropzone.SUCCESS,
                };
                dzInstance.emit('addedfile', mockFile);
                dzInstance.files.push(mockFile);
                if (previewAsImage) {
                    dzInstance.emit('thumbnail', mockFile, item.url);
                }
                dzInstance.emit('complete', mockFile);

                // Item yang berasal dari temp (selamat dari validasi gagal di field lain)
                // langsung dipasang lagi hidden input-nya, supaya ikut ke-submit ulang
                // tanpa perlu di-upload dari awal.
                if (item.is_temp) {
                    tambahHiddenInput(item.temp_name);
                }
            });
        },
    });

    dz.on('success', function (file, response) {
        file.tempName = response.name;
        tambahHiddenInput(response.name);
    });

    dz.on('error', function (file, message) {
        const pesan = typeof message === 'string' ? message : (message?.errors ? Object.values(message.errors).flat().join(', ') : 'Upload gagal.');
        if (file.previewElement) {
            file.previewElement.classList.add('dz-error');
            const errEl = file.previewElement.querySelector('[data-dz-errormessage]');
            if (errEl) errEl.textContent = pesan;
        }
    });

    dz.on('removedfile', function (file) {
        if (file.existingMediaId) {
            // File yang SUDAH tersimpan - hapus langsung (AJAX), tidak ditunda sampai submit.
            fetch(el.dataset.deleteExistingUrlBase + '/' + file.existingMediaId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    Accept: 'application/json',
                },
            });
        } else if (file.tempName) {
            // File baru yang masih di folder temp - hapus dari situ + lepas hidden input-nya.
            fetch(el.dataset.deleteTempUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                body: JSON.stringify({ context: context, name: file.tempName }),
            });
            hapusHiddenInput(file.tempName);
        }
    });

    return dz;
}
