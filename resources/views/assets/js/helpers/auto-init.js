// import $ from "jquery";

export function autoInit() {
    // --- Select2 ---
    const select2Els = $(".select2, .select2-tags");

    if (select2Els.length) {
        import("./my-select2").then(({ initSelect2 }) => {
            select2Els.each(function () {
                const options = {
                    placeholder: $(this).data("placeholder") || "",
                    // allowClear: true,
                };

                if ($(this).hasClass("select2-tags")) {
                    options.tags = true;
                    options.tokenSeparators = [","];
                }

                initSelect2(this, options);
            });
        });
    }

    // --- Selectric ---
    const selectricEls = $(".selectric");
    if (selectricEls.length) {
        import("./my-selectric").then(({ initSelectric }) => {
            selectricEls.each(function () {
                initSelectric(this);
            });
        });
    }

    // --- Tempus Dominus ---
    // const tempusEls = document.querySelectorAll("[data-tempus]");
    // if (tempusEls.length) {
    //     import("./my-datetimepicker").then(({ initTempus }) => {
    //         tempusEls.forEach((el) => {
    //             const format = el.dataset.format || "YYYY-MM-DD HH:mm:ss";
    //             initTempus(el, format);
    //         });
    //     });
    // }

    // // --- jQuery Mask ---
    // const maskList = {
    //     ".mask-price": {
    //         pattern: "000.000.000.000.000",
    //         reverse: true,
    //     },
    //     ".mask-ktp": {
    //         pattern: "0000000000000000",
    //     },
    //     ".mask-hp": {
    //         pattern: "0000-0000-0000",
    //     },
    //     ".mask-phone": {
    //         pattern: "(000) 0000-0000",
    //     },
    //     ".mask-npwp": {
    //         pattern: "00.000.000.0-000.000",
    //     },
    //     ".mask-rekening": {
    //         pattern: "0000000000000000",
    //     },
    //     ".mask-date": {
    //         pattern: "00-00-0000",
    //     },
    //     ".mask-time": {
    //         pattern: "00:00",
    //     },
    //     ".mask-kodepos": {
    //         pattern: "00000",
    //     },
    //     ".mask-sim": {
    //         pattern: "000000000000",
    //     },
    //     ".mask-passport": {
    //         pattern: "A0000000",
    //     },
    //     ".mask-year": {
    //         pattern: "0000",
    //     },
    // };

    // Object.entries(maskList).forEach(([cls, cfg]) => {
    //     if (document.querySelector(cls)) {
    //         import("./my-mask").then(({ initMask }) => {
    //             document.querySelectorAll(cls).forEach((el) => {
    //                 initMask(el, cfg);
    //             });
    //         });
    //     }
    // });

    // --- GLightbox (galeri foto, mis. foto nota pembelian) ---
    const glightboxEls = document.querySelectorAll(".glightbox");
    if (glightboxEls.length) {
        import("./my-glightbox").then(({ initGlightbox }) => {
            initGlightbox();
        });
    }

    const filepondEls = document.querySelectorAll(".filepond");

    if (filepondEls.length) {
        import("./my-filepond").then(({ initFilePond }) => {
            filepondEls.forEach((el) => {
                initFilePond(el, {
                    allowMultiple: el.hasAttribute("multiple"),
                });
            });
        });
    }
}
