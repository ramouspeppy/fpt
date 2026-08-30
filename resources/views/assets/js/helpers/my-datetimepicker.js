export async function initTempus(selector, format = 'YYYY-MM-DD HH:mm:ss') {
    const {
        TempusDominus
    } = await import('@eonasdan/tempus-dominus');
    const moment = (await import('moment')).default;

    const el = typeof selector === 'string' ? document.querySelector(selector) : selector;
    if (!el) return;

    new TempusDominus(el, {
        display: {
            buttons: {
                today: true,
                clear: true,
                close: true,
            }
        },
        hooks: {
            inputFormat: (context, date) => {
                if (date) return moment(date).format(format);
                return null;
            }
        }
    });
}
