import {
    Flip
} from 'gsap/Flip';
import gsap from 'gsap';
import Chocolat from 'chocolat';
import Swal from 'sweetalert2';
import $ from 'jquery';

gsap.registerPlugin(Flip);
window.swal = Swal;

export function initPhotoDeliveryPage() {
    // Inisialisasi lightbox
    function chocolata() {
        chocolat(document.querySelectorAll('.chocolat-image'), {
            loop: true
        });
    }

    chocolata();

    // Setup Ajax CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        data: {
            _token: $('meta[name="_token"]').attr('content')
        }
    });

    // Select All Checkbox
    $('#chkCheckAll').click(function () {
        $(".checkbox-delivery").prop('checked', $(this).prop('checked'));
    });

    // Tombol Delete All
    $('#deleteAll').on('click', function (e) {
        e.preventDefault();

        if ($('input:checkbox[name=idDeliveries]:checked').length) {
            swal.fire({
                title: 'Are you sure?',
                text: "Move these data to the trash !",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.cardProgress('#card-photo-delivery', {
                        dismiss: false
                    });
                    deleteDataAll();
                } else if (result.dismiss === swal.DismissReason.cancel) {
                    swal.fire('Cancelled', 'Your data is safe :)', 'info');
                }
            });

        } else {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'At least choose one data..!!',
            });
        }
    });

    function deleteDataAll() {
        const allIds = [];

        $('input:checkbox[name=idDeliveries]:checked').each(function () {
            allIds.push($(this).val());
        });

        $.ajax({
            type: "POST",
            url: window.photoDeliveryDeleteUrl, // gunakan dari blade
            data: {
                _method: "DELETE",
                data: allIds
            },
            success: function (data) {
                $.cardProgressDismiss('#card-photo-delivery');

                if (data.msg) {
                    swal.fire({
                        title: 'Info!',
                        html: data.msg,
                        icon: 'info',
                    });
                } else {
                    const state = Flip.getState(".photo-delivery-container");

                    $(".checkbox-delivery:checked").each(function () {
                        $(this).closest(".photo-delivery-container").remove();
                    });

                    Flip.from(state, {
                        duration: 0.5,
                        ease: "power1.inOut",
                        stagger: 0.05,
                        onComplete: () => {
                            try {
                                document.querySelectorAll('.chocolat-open').forEach(c => c.classList.remove('chocolat-open'));
                                const overlay = document.querySelector('.chocolat-overlay');
                                const lightbox = document.querySelector('.chocolat-wrapper');
                                if (overlay) overlay.remove();
                                if (lightbox) lightbox.remove();
                            } catch (e) {
                                console.warn('Manual Chocolat destroy error:', e);
                            }

                            chocolat(document.querySelectorAll('.chocolat-image'), {
                                loop: true
                            });
                        }
                    });
                }
            },
            error: function () {
                swal.fire({
                    title: 'Error!',
                    html: 'Gagal menghapus data. Silakan coba lagi.',
                    icon: 'error',
                });
            }
        });
    }
}
