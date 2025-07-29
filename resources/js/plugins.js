window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {

    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'
import 'jquery-mask-plugin';
import 'tocca';
import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock';
import * as EmailValidator from 'email-validator';
import SmoothScroll from 'smooth-scroll';

// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
$(document).ready(function () {
    const [sidebar] = $('.sidebar');
    const [overlay] = $('.sidebar-overlay');
    const bodyScrollOptions = {
        reserveScrollBarGap: true
    }

    //Menu accordion
    $(".link-title").on("click", function(e) {
        const [panel] = $(this).next('.link-items')
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null
            $(this).removeClass("link-items__is-reveal")
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
            $(this).addClass("link-items__is-reveal")
        }
    })

    //Menu subitem accordion
    $(".second-level").on("click", function(e) {
        e.preventDefault()
        const [panel] = $(this).next('.link-second-level')
        const [parentPanel] = $(this).parents('.link-items');
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null
            $(this).removeClass("link-items__is-reveal")
        } else {
            parentPanel.style.maxHeight = parentPanel.scrollHeight + parentPanel.scrollHeight + "px"
            panel.style.maxHeight = panel.scrollHeight + "px";
            $(this).addClass("link-items__is-reveal")
        }
    })

    //desktop header scroll dvent
    $(document).on( 'scroll', function() {
        let xlHeader = $(".header-media")
        let offsetY = $(this).scrollTop()
        if (offsetY > 0) xlHeader.addClass("header-scroll")
        else xlHeader.removeClass("header-scroll")
        // console.log($(this).scrollTop() );

     });

    //mobile menu trigger
    $(".hamburger").on( "click", function() {
        disableBodyScroll(sidebar);
        $(sidebar).addClass("is-open-sidebar")
        $(overlay).fadeIn(300)
    });
    $(".sidebar__close").on( "click", function() {
        enableBodyScroll(sidebar);
        $(sidebar).removeClass("is-open-sidebar")
        $(overlay).fadeOut(300)
    });
    $(overlay).on("click", function() {
        enableBodyScroll(sidebar);
        $(sidebar).removeClass("is-open-sidebar")
        $(overlay).fadeOut(300)
    })
    $(".sidebar, .item-link").on("swipeleft", function() {
        enableBodyScroll(sidebar);
        $(sidebar).removeClass("is-open-sidebar")
        $(overlay).fadeOut(300)
    });

    // desktop menu trigger
    $(".menu-hamburger").on( "click", function(e) {
        const scroll = new SmoothScroll();
        const desktopMenu = $(".menu-holder")
        if (e.target.checked) {
            desktopMenu.fadeIn()
            disableBodyScroll(desktopMenu, bodyScrollOptions)
        } else {
            desktopMenu.fadeOut();
            clearAllBodyScrollLocks()
        }
        // scroll.animateScroll(0, null, {
        //     speed: 1
        // });
    })




    // subscribe
    $('#subscribe_email').on('input', function() {
        const email = $(this).val();
        const isEmail = EmailValidator.validate(email);
        isEmail ? $(this).removeClass('incorrect') : $(this).addClass('incorrect')
        if (!email.length) $(this).removeClass('incorrect')
    });
    $("#subscribe").on("click", function(e) {
        const email = $('#subscribe_email').val();
        if (email.length) {
            let isAjax = true
            const isEmail = EmailValidator.validate(email);
            const btn = $("#subscribe")
            if (isEmail && isAjax) {
                const url = '/api/email-subscription'
                isAjax = false
                btn.addClass('inprogress')
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { 'email': email }
                    })
                    .done(function( data ) {
                        btn.removeClass('inprogress')
                        if (data.error) return showMessage(data.error, false)
                        showMessage(data.success)
                        $('#subscribe_email').val('')
                        isAjax = true
                    });
            } else showMessage('Введенный e-mail не верный', false)
        } else showMessage('Пожалуйста, введете e-mail', false)
    })

    //mask
    $('#phone').mask("+7 (999) 999-99-99", {
        placeholder: "+7 (•••) •••-••-••",
        clearIfNotMatch: true,
        selectOnFocus: true,
    });

    //login
    $("#login").on("click", function(e) {
        e.preventDefault();
        const email = $("input[name='email']").val();
        const password = $("input[name='password']").val();
        if (email.length) {
            let isAjax = true
            if (isAjax) {
                $(this).addClass('inprogress')
                const url = '/api/login'
                isAjax = false
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        email: email,
                        password: password
                     }
                    })
                    .done(function( data ) {
                        $("#login").removeClass('inprogress')
                        if (data.error) showMessage(data.error, false)
                        if (data === 'success') $("#login-success").click()
                        isAjax = true
                    });
            }
        } else {
            showMessage('Пожалуйста, введете e-mail', false)
            $("input[name='email']").css('border-color', 'red')
        }
    })

    $("input[name='email']").on('input', function() {
        $(this).removeAttr('style');
    });

    //register
    // $("#register, #resend, #sendlink").on("click", function(e) {
    //     $(this).addClass('inprogress')
    // })

    // return
    $("#return-btn").on("click", function(e) {
        e.preventDefault();
        console.log();
        var isAjax = true
        $('.ui_from-group').each(function() {
            let input = $(this).find('.form-control');
            let inputVal = input.val()
            if (inputVal === '') {
                input.css('border-color', 'red')
                showMessage('Пожалйста, заполните всю форму', false)
                setTimeout(() => {
                    input.css('border-color', '#E5E5E5')
                }, 4000);
                isAjax = false
            }
        })
        if (isAjax) {
            $("#return-btn").addClass('inprogress')
            const url = '/api/return'
            isAjax = false
            const form = $("#form-return").serialize()
            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form
                })
                .done(function( data ) {
                    $("#return-btn").removeClass('inprogress')
                    showMessage(data.success)
                    isAjax = true
                    $('.ui_from-group').each(function() {
                        $(this).find('.form-control').val('');
                    })
                });
        }
    })

});

const showMessage = (msg, isValid = true) => {
    $('.message-text').text(msg)
    if (!isValid) $('.message-snackbar').addClass('error')
    $('.message-snackbar').addClass('show')
    setTimeout(() => { $('.message-snackbar').removeClass('show error') }, 3000);
}

export { showMessage };
