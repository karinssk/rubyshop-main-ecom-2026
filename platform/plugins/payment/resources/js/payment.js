'use strict'

var BPayment = BPayment || {}

BPayment.initResources = function () {
    let paymentMethod = $(document).find('input[name=payment_method]:checked').first()

    if (!paymentMethod.length) {
        paymentMethod = $(document).find('input[name=payment_method]').first()
        paymentMethod.trigger('click').trigger('change')
    }

    if (paymentMethod.length) {
        paymentMethod.closest('.list-group-item').find('.payment_collapse_wrap').addClass('show')
    }

    if ($('.stripe-card-wrapper').length > 0) {
        new Card({
            // a selector or DOM element for the form where users will
            // be entering their information
            form: '.payment-checkout-form', // *required*
            // a selector or DOM element for the container
            // where you want the card to appear
            container: '.stripe-card-wrapper', // *required*

            formSelectors: {
                numberInput: 'input#stripe-number', // optional — default input[name="number"]
                expiryInput: 'input#stripe-exp', // optional — default input[name="expiry"]
                cvcInput: 'input#stripe-cvc', // optional — default input[name="cvc"]
                nameInput: 'input#stripe-name', // optional - defaults input[name="name"]
            },

            width: 350, // optional — default 350px
            formatting: true, // optional - default true

            // Strings for translation - optional
            messages: {
                validDate: 'valid\ndate', // optional - default 'valid\nthru'
                monthYear: 'mm/yyyy', // optional - default 'month/year'
            },

            // Default placeholders for rendered fields - optional
            placeholders: {
                number: '•••• •••• •••• ••••',
                name: 'Full Name',
                expiry: '••/••',
                cvc: '•••',
            },

            masks: {
                cardNumber: '•', // optional - mask card number
            },

            // if true, will log helpful messages for setting up Card
            debug: false, // optional - default false
        })
    }
}

BPayment.init = function () {
    BPayment.initResources()

    $(document).on('click', '.delete-all-transactions-button', function (event) {
        event.preventDefault()
        event.stopPropagation()

        const button = $(event.currentTarget)
        const url = button.find('span[data-href]').data('href')
        const tableId = button.closest('.table-wrapper').find('.table').prop('id')

        if (!url || !tableId) {
            return
        }

        const modal = $('.single-action-confirm-modal')
        const confirmButton = modal.find('.confirm-trigger-single-action-button')

        confirmButton
            .data('href', url)
            .data('method', 'delete')
            .data('table-id', tableId)
            .data('payment-delete-all', true)

        modal.find('.modal-body > h3').text(
            BotbleVariables.languages.tables.confirm_delete || 'Confirm delete'
        )
        modal.find('.modal-body > .text-muted').text(
            BotbleVariables.languages.tables.confirm_delete_all_msg || 'Do you really want to delete all record?'
        )
        modal.find('button.btn[data-bs-dismiss="modal"]').text(
            BotbleVariables.languages.tables.cancel || 'Cancel'
        )
        confirmButton.text(BotbleVariables.languages.tables.delete || 'Delete')

        modal.modal('show')
    })

    $(document).on('click', '.confirm-trigger-single-action-button', function (event) {
        const button = $(event.currentTarget)

        if (!button.data('payment-delete-all')) {
            return
        }

        event.preventDefault()
        event.stopImmediatePropagation()

        const url = button.data('href')
        const tableId = button.data('table-id')
        const modal = button.closest('.modal')

        Botble.showButtonLoading(button)

        $httpClient
            .make()
            .delete(url)
            .then(({ data }) => {
                Botble.showSuccess(data.message)
                modal.modal('hide')

                if (window.LaravelDataTables && window.LaravelDataTables[tableId]) {
                    window.LaravelDataTables[tableId].draw()
                }
            })
            .finally(() => {
                Botble.hideButtonLoading(button)
            })
    })

    $(document).on('hidden.bs.modal', '.single-action-confirm-modal', function (event) {
        $(event.currentTarget)
            .find('.confirm-trigger-single-action-button')
            .removeData('payment-delete-all')
    })

    $(document).on('change', '.js_payment_method', function (event) {
        event.preventDefault()

        $('.payment_collapse_wrap').removeClass('collapse').removeClass('show').removeClass('active')

        $(event.currentTarget)
            .closest('.list-group-item')
            .find('.payment_collapse_wrap')
            .addClass('show')
            .addClass('active')
    })

    $(document)
        .off('click', '.payment-checkout-btn')
        .on('click', '.payment-checkout-btn', function (event) {
            event.preventDefault()

            const button = $(event.currentTarget)
            const form = button.closest('form')
            const submitInitialText = button.html()

            if (form.valid && !form.valid()) {
                return
            }

            button.prop('disabled', true)
            button.html(
                `<span class="spinner-border spinner-border-sm me-2" role="status"></span> ${button.data('processing-text')}`
            )

            if ($('input[name=payment_method]:checked').val() === 'stripe' && $('.stripe-card-wrapper').length > 0) {
                Stripe.setPublishableKey($('#payment-stripe-key').data('value'))
                Stripe.card.createToken(form, function (status, response) {
                    if (response.error) {
                        if (typeof Botble != 'undefined') {
                            Botble.showError(response.error.message, button.data('error-header'))
                        } else {
                            alert(response.error.message)
                        }
                        button.prop('disabled', false)
                        button.html(submitInitialText)
                    } else {
                        form.append($('<input type="hidden" name="stripeToken">').val(response.id))
                        form.submit()
                    }
                })
            } else {
                form.submit()
            }
        })
}

$(document).ready(function () {
    BPayment.init()

    document.addEventListener('payment-form-reloaded', function () {
        BPayment.initResources()
    })
})
