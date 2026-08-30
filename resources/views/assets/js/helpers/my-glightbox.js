import GLightbox from "glightbox";

let instance = null;

export function initGlightbox(config = {}) {
    // 🔥 destroy instance lama (hindari double init)
    if (instance) {
        instance.destroy();
    }

    instance = GLightbox({
        selector: ".glightbox",
        touchNavigation: true,
        loop: true,
        zoomable: true,
        ...config,
    });

    console.info("✅ Glightbox initialized (modular)");
    return instance;
}
