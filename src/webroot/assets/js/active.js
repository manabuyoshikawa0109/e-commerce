(function () {
    'use strict';

    var suhaWindow = $(window);

    /* =========================
       PRELOADER
    ========================== */
    suhaWindow.on('load', function () {
        $('#preloader').fadeOut('1000', function () {
            $(this).remove();
        });
    });

    /* =========================
       DROPDOWN MENU
    ========================== */
    $(".sidenav-nav").find("li.suha-dropdown-menu").append("<div class='dropdown-trigger-btn'><i class='ti ti-chevron-down'></i></div>");
    $(".dropdown-trigger-btn").on('click', function () {
        $(this).siblings('ul').stop(true, true).slideToggle(700);
        $(this).toggleClass('active');
    });

    /* =========================
       COUNTER UP
    ========================== */
    if ($.fn.counterUp) {
        $('.counter').counterUp({
            delay: 150,
            time: 3000
        });
    }

    /* =========================
       NICE SELECT
    ========================== */
    if ($.fn.niceSelect) {
        $('#selectProductCatagory, #topicSelect, #countryCodeSelect').niceSelect();
    }

    /* =========================
       PREVENT DEFAULT 'A' CLICK
    ========================== */
    $('a[href="#"]').on('click', function ($) {
        $.preventDefault();
    });

    /* =========================
       PASSWORD STRENGTH
    ========================== */
    if ($.fn.passwordStrength) {
        $('#registerPassword').passwordStrength({
            minimumChars: 8
        });
    }

    /* =========================
       MAGNIFIC POPUP
    ========================== */
    if ($.fn.magnificPopup) {
        $('#singleProductVideoBtn, #videoButton').magnificPopup({
            type: "iframe"
        });
    }

    /* =========================
       REVIEW IMAGE MAGNIFIC POPUP
    ========================== */
    if ($.fn.magnificPopup) {
        $('.review-image').magnificPopup({
            type: "image"
        });
    }

    /* =========================
       CART QUANTITY BUTTON HANDLER
    ========================== */
    $(document).off('click', '.quantity-button-handler');

    $(document).on('click', '.quantity-button-handler', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let wrapper = $(this).closest('.order-plus-minus');
        let input = wrapper.find('.cart-quantity-input');
        let value = parseInt(input.val(), 10) || 1;

        if ($(this).hasClass('plus')) {
            value = value + 1;
        }

        if ($(this).hasClass('minus')) {
            value = value > 1 ? value - 1 : 1;
        }

        input.val(value);
    });

    /* =========================
       DATA COUNTDOWN
    ========================== */
    const countdownElements = $('[data-countdown]');

    if (countdownElements.length > 0) {
        countdownElements.each(function () {
            const $this = $(this);
            const finalDate = $(this).data('countdown');

            $this.countdown(finalDate, function (event) {
                $(this).find(".days").html(event.strftime("%D"));
                $(this).find(".hours").html(event.strftime("%H"));
                $(this).find(".minutes").html(event.strftime("%M"));
                $(this).find(".seconds").html(event.strftime("%S"));
            });
        });
    }

})();

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* =========================
       HERO SLIDES (Swiper)
    ========================== */
    if (typeof Swiper !== 'undefined') {

        var welcomeSlider = new Swiper('.hero-slides', {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });

        // Slide change start
        welcomeSlider.on('slideChangeTransitionStart', function () {
            var layer = document.querySelectorAll("[data-animation]");
            layer.forEach(function (el) {
                var anim_name = el.getAttribute('data-animation');
                el.classList.remove('animated', anim_name);
                el.style.opacity = '0';
            });
        });

        // Delay set
        document.querySelectorAll("[data-delay]").forEach(function (el) {
            el.style.animationDelay = el.getAttribute('data-delay');
        });

        // Duration set
        document.querySelectorAll("[data-duration]").forEach(function (el) {
            el.style.animationDuration = el.getAttribute('data-duration');
        });

        // Slide change end
        welcomeSlider.on('slideChangeTransitionEnd', function () {
            var activeSlide = document
                .querySelector('.hero-slides .swiper-slide-active')
                .querySelectorAll("[data-animation]");

            activeSlide.forEach(function (el) {
                var anim_name = el.getAttribute('data-animation');
                el.classList.add('animated', anim_name);
                el.style.opacity = '1';
            });
        });
    }

    /* =========================
       FLASH SALE SLIDES (Swiper)
    ========================== */
    if (typeof Swiper !== 'undefined') {

        var flashSlide = new Swiper('.flash-sale-slide', {
            slidesPerView: 3,
            spaceBetween: 8,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            speed: 800,
            navigation: false,
            pagination: false,
            breakpoints: {
                992: {
                    slidesPerView: 4
                }
            }
        });
    }

    /* =========================
       COLLECTION SLIDES (Swiper)
    ========================== */
    if (typeof Swiper !== 'undefined') {
        var collectionSlide = new Swiper('.collection-slide', {
            slidesPerView: 3,
            spaceBetween: 8,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            speed: 800,
            pagination: false,
            navigation: false,

            breakpoints: {
                992: {
                    slidesPerView: 4
                }
            }
        });
    }

    /* =========================
       PRODUCTS SLIDES (Swiper)
    ========================== */
    if (typeof Swiper !== 'undefined') {
        var productSlides = new Swiper('.product-slides', {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: false,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            navigation: {
                nextEl: '.product-slide-next',
                prevEl: '.product-slide-prev'
            }
        });
    }

    /* =========================
       CATAGORY SLIDES (Swiper)
    ========================== */
    if (typeof Swiper !== 'undefined') {
        var catagorySlides = new Swiper('.catagory-slides', {
            slidesPerView: 2.5,
            spaceBetween: 4,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            pagination: false,
            navigation: false,

            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                992: {
                    slidesPerView: 4
                }
            }
        });
    }

    /* =========================
       RELATED PRODUCTS SLIDES (Swiper)
    ========================== */
    if (typeof Swiper !== 'undefined') {
        var relatedProductSlide = new Swiper('.related-product-slide', {
            slidesPerView: 2,
            spaceBetween: 8,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            pagination: false,
            navigation: false,

            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }
            }
        });
    }

    /* =========================
       WISHLIST ICON TOGGLE
    ========================== */

    document.querySelectorAll('.wishlist-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var heartIcon = this.querySelector('i');
            if (!heartIcon) return;

            heartIcon.classList.toggle('ti-heart-filled');
            heartIcon.classList.toggle('ti-heart');
        });
    });

    /* =========================
       BOOTSTRAP TOOLTIPS
    ========================== */

    var tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipElements.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });

    /* =========================
       BOOTSTRAP TOASTS
    ========================== */

    var toastElements = document.querySelectorAll('.toast');
    toastElements.forEach(function (el) {
        var toast = new bootstrap.Toast(el);
        toast.show();
    });
});