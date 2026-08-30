import $ from "jquery";

let select2Loaded = false;

export async function initSelect2(selector, options = {}) {
    if (!select2Loaded) {
        const module = await import("select2");

        module.default($);

        select2Loaded = true;
    }

    const el = $(selector);

    if (!el.length) return;

    el.select2(options);
}
