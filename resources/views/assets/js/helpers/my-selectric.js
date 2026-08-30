// my-selectric.js

import $ from 'jquery';

export async function initSelectric(selector, config = {}) {
    await import('jquery-selectric'); // sesuai struktur Anda
    const el = $(selector);
    if (!el.length) return;

    el.selectric(config);
}
