class ContactPluginManagement {
    logDeleteAll(message, payload = null, method = 'log') {
        const prefix = '[Contact delete all]'

        if (payload === null) {
            console[method](prefix, message)

            return
        }

        console[method](prefix, message, payload)
    }

    init() {
        this.logDeleteAll('Debug script initialized')

        $(document).on('click', '.delete-all-contacts-button', (event) => {
            event.preventDefault()
            event.stopPropagation()

            const button = $(event.currentTarget)
            const url = button.find('span[data-href]').data('href')
            const tableId = button.closest('.table-wrapper').find('.table').prop('id')

            this.logDeleteAll('Delete button clicked', {
                url,
                tableId,
            })

            if (!url || !tableId) {
                this.logDeleteAll('Missing url or table id before opening confirm modal', {
                    url,
                    tableId,
                }, 'error')

                return
            }

            const modal = $('.single-action-confirm-modal')
            const confirmButton = modal.find('.confirm-trigger-single-action-button')

            confirmButton
                .data('href', url)
                .data('method', 'delete')
                .data('table-id', tableId)
                .data('contact-delete-all', true)

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

            this.logDeleteAll('Opening confirm modal', {
                url,
                tableId,
            })

            modal.modal('show')
        })

        $(document).on('click', '.confirm-trigger-single-action-button', (event) => {
            const button = $(event.currentTarget)

            if (!button.data('contact-delete-all')) {
                return
            }

            event.preventDefault()
            event.stopImmediatePropagation()

            const url = button.data('href')
            const tableId = button.data('table-id')
            const modal = button.closest('.modal')

            this.logDeleteAll('Confirm button clicked', {
                url,
                tableId,
            })

            Botble.showButtonLoading(button)

            $httpClient
                .make()
                .delete(url)
                .then(({ data }) => {
                    this.logDeleteAll('Delete request succeeded', data)

                    Botble.showSuccess(data.message)
                    modal.modal('hide')

                    if (window.LaravelDataTables && window.LaravelDataTables[tableId]) {
                        window.LaravelDataTables[tableId].draw()
                    } else {
                        this.logDeleteAll('DataTable instance not found after delete', {
                            tableId,
                        }, 'warn')
                    }
                })
                .catch((error) => {
                    const responseData = error?.response?.data || null

                    this.logDeleteAll('Delete request failed', {
                        message: error?.message,
                        response: responseData,
                    }, 'error')

                    Botble.showError(
                        responseData?.message || error?.message || 'Delete all contacts failed'
                    )
                })
                .finally(() => {
                    Botble.hideButtonLoading(button)
                })
        })

        $(document).on('hidden.bs.modal', '.single-action-confirm-modal', (event) => {
            const modal = $(event.currentTarget)
            const confirmButton = modal.find('.confirm-trigger-single-action-button')

            confirmButton.removeData('contact-delete-all')

            this.logDeleteAll('Confirm modal closed and debug state cleared')
        })

        $(document).on('click', '.answer-trigger-button', (event) => {
            event.preventDefault()
            event.stopPropagation()

            const answerWrapper = $('.answer-wrapper')
            if (answerWrapper.is(':visible')) {
                answerWrapper.fadeOut()
            } else {
                answerWrapper.fadeIn()
            }

            window.EDITOR = new EditorManagement().init()
        })

        $(document).on('click', '.answer-send-button', (event) => {
            event.preventDefault()
            event.stopPropagation()

            const _self = $(event.currentTarget)

            Botble.showButtonLoading(_self)

            let message = $('#message').val()
            if (typeof tinymce != 'undefined') {
                message = tinymce.get('message').getContent()
            }

            $httpClient
                .make()
                .post(_self.data('url'), {
                    message,
                })
                .then(({ data }) => {
                    $('.answer-wrapper').fadeOut()

                    if (typeof tinymce != 'undefined') {
                        tinymce.get('message').setContent('')
                    } else {
                        $('#message').val('')
                        const domEditableElement = document.querySelector('.answer-wrapper .ck-editor__editable')
                        if (domEditableElement) {
                            const editorInstance = domEditableElement.ckeditorInstance

                            if (editorInstance) {
                                editorInstance.setData('')
                            }
                        }
                    }

                    Botble.showSuccess(data.message)

                    $('#reply-wrapper').load(window.location.href + ' #reply-wrapper > *')
                })
                .finally(() => {
                    Botble.hideButtonLoading($(event.currentTarget))
                })
        })
    }
}

$(() => {
    new ContactPluginManagement().init()
})
