let FilePond;

export async function initFilePond(el, options = {}) {
    if (!FilePond) {
        const module = await import("filepond");
        FilePond = module.default;

        await import("filepond/dist/filepond.min.css");
        // await import("./filepond-custom.css");
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

    return FilePond.create(el, {
        labelIdle: defaultLabel,
        allowprocess: false,
        credits: false,
        ...options,
    });
}
