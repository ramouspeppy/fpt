import $ from "jquery";

/**
 * Menampilkan progress pada card
 * @param {HTMLElement|string} card
 */
export function cardProgress(card) {
    const $card = $(card);
    $card.addClass("card-progress");
}

/**
 * Menghapus progress pada card
 * @param {HTMLElement|string} card
 * @param {Function} [dismissed]
 */
export function cardProgressDismiss(card, dismissed) {
    const $card = $(card);
    $card.removeClass("card-progress");
    $card.find(".card-progress-dismiss").remove();
    if (typeof dismissed === "function") dismissed.call(this, $card);
}

// Jadikan global
window.cardProgress = cardProgress;
window.cardProgressDismiss = cardProgressDismiss;
