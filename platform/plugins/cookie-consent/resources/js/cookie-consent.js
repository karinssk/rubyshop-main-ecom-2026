'use strict'

$(() => {
    window.botbleCookieConsent = (function () {
        const COOKIE_VALUE = 1
        const COOKIE_NAME = $('div[data-site-cookie-name]').data('site-cookie-name')
        const COOKIE_DOMAIN = $('div[data-site-cookie-domain]').data('site-cookie-domain')
        const COOKIE_LIFETIME = $('div[data-site-cookie-lifetime]').data('site-cookie-lifetime')
        const SESSION_SECURE = $('div[data-site-session-secure]').data('site-session-secure')

        const $cookieDialog = $('.js-cookie-consent')

        if (!cookieExists(COOKIE_NAME)) {
            $cookieDialog.addClass('cookie-consent--visible')
        } else {
            hideCookieDialog()
        }

        function consentWithCookies() {
            setCookie(COOKIE_NAME, COOKIE_VALUE, COOKIE_LIFETIME)
            hideCookieDialog()
        }

        function cookieExists(name) {
            return document.cookie
                .split(';')
                .map(cookie => cookie.trim())
                .some(cookie => cookie === name + '=' + COOKIE_VALUE)
        }

        function hideCookieDialog() {
            $cookieDialog.hide()
        }

        function setCookie(name, value, expirationInDays) {
            const date = new Date()
            date.setTime(date.getTime() + expirationInDays * 24 * 60 * 60 * 1000)

            const secure = SESSION_SECURE || ''
            const baseCookie =
                name +
                '=' +
                value +
                ';expires=' +
                date.toUTCString() +
                ';path=/;SameSite=Lax' +
                secure

            if (COOKIE_DOMAIN) {
                document.cookie = baseCookie + ';domain=' + COOKIE_DOMAIN
            }

            if (!cookieExists(name)) {
                document.cookie = baseCookie
            }

            if (!cookieExists(name) && secure) {
                document.cookie = baseCookie.replace(secure, '')
            }
        }

        $(document).on('click', '.js-cookie-consent-agree', function () {
            consentWithCookies()
        })

        return {
            consentWithCookies: consentWithCookies,
            hideCookieDialog: hideCookieDialog,
        }
    })()
})
