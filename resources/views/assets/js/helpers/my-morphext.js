let loaded = false;

async function loadMorphext() {
    if (!loaded) {
        // Plugin jQuery klasik (nempel ke $.fn.Morphext), butuh window.jQuery
        // yang sudah di-set global di bootstrap.js - dimuat dulu baru plugin-nya.
        //
        // PENTING: import LANGSUNG ke file dist-nya (bukan cuma "morphext" saja).
        // package.json bawaan "morphext" di npm salah menunjuk entry point-nya,
        // jadi kalau di-import sebagai nama package polos, Vite malah coba resolve
        // ke Gruntfile.coffee (file build tools si package, bukan kode plugin) dan
        // error "Unexpected token '>'". Import langsung ke dist/morphext.min.js
        // melewati masalah resolusi itu sepenuhnya.
        await import("morphext/dist/morphext.min.js");
        loaded = true;
    }
}

// Dipasang lewat class "morphext" di elemen yang isinya teks dipisah koma, contoh:
// <span class="morphext" data-effect="fadeIn">Kerapu Sunu, Kerapu Sawai, Kerapu Ekor Kuning</span>
// Kalau isinya cuma 1 nama (tidak ada koma) atau kosong, tetap ditampilkan diam
// (tidak perlu dianimasikan - Morphext tetap aman dipanggil, cuma tidak terlihat "muter").
export async function initMorphext(el, options = {}) {
    await loadMorphext();

    if (!window.jQuery) {
        return; // jQuery belum siap - jangan sampai error, biarkan teks tampil statis
    }

    window.jQuery(el).Morphext({
        animation: el.dataset.effect || "fadeIn",
        separator: ",",
        speed: 2200,
        ...options,
    });
}
