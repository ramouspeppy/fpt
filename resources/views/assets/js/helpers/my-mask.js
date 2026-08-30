import $ from 'jquery';
export async function initMask(selector, config = {}) {
    await import('jquery-mask-plugin');
    const el = $(selector);
    if (!el.length) return;

    el.mask(config.pattern, {
        reverse: config.reverse !== false
    });
}
