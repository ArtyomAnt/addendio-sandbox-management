/**
 * Addendio Sandbox Management Public functions & definitions.
 */
(function ($) {
    "use strict";

    $(function () {

        var addendioPublic = {
            /**
             * Vars
             */
            $box: $("#addendio-forms"),

            init: function () {
                // Setting defaults for Noty
                Noty.overrideDefaults({
                    layout: 'topRight',
                    timeout: 5000,
                    progressBar: true,
                    closeWith: ['click'],
                    animation: {
                        open: 'noty_effects_open',
                        close: 'noty_effects_close'
                    },
                    queue: 'global',
                    modal: false
                });

                // Registering Events
                this.events();
            },

            events: function () {

                $("#addendio-form-login").on("submit", function (event) {
                    event.preventDefault();
                    addendioPublic.formLogin.processForm($(this));
                    addendioPublic.ajaxSpinner.add(addendioPublic.$box);
                });

                $("#addendio-form-register").on("submit", function (event) {
                    event.preventDefault();
                    addendioPublic.formRegister.processForm($(this));
                    addendioPublic.ajaxSpinner.add(addendioPublic.$box);
                });

                $("#addendio-form-password-recovery").on("submit", function (event) {
                    event.preventDefault();
                    addendioPublic.formPasswordRecovery.processForm($(this));
                    addendioPublic.ajaxSpinner.add(addendioPublic.$box);

                });

                $(".js-addendio-login-form-switch").on("click", function (event) {
                    event.preventDefault();
                    $(this).closest(".addendio-form").slideUp();
                    $($(this).attr("href")).slideDown();
                });

            },

            formLogin: {
                processForm: function (form) {
                    form.validate();
                    var url = form.data("profile");

                    if (!form.valid()) {
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: addendioPublicData.ajaxUrl,
                        data: {
                            action: 'handle_request',
                            addendio_action: 'login',
                            addendio_data: form.serialize()
                        },
                        success: function (response) {
                            if (response.success === true) {
                                new Noty({
                                    text: response.data.message,
                                    type: 'success'
                                }).show();
                                form[0].reset();
                                window.location.href = url, true;
                            } else {
                                new Noty({
                                    text: response.data.message,
                                    type: 'error'
                                }).show();
                            }

                        },
                        error: function (errorThrown) {
                            // Throw Common Server Error
                            new Noty({
                                text: addendioPublicData.messages.error.server.common,
                                type: 'error'
                            }).show();
                        },
                        complete: function () {
                            addendioPublic.ajaxSpinner.remove();
                        }
                    });
                }
            },

            formRegister: {
                processForm: function (form) {
                    form.validate();

                    if (!form.valid()) {
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: addendioPublicData.ajaxUrl,
                        data: {
                            action: 'handle_request',
                            addendio_action: 'register',
                            addendio_data: form.serialize()
                        },
                        success: function (response) {
                            new Noty({
                                text: response.data.message,
                                type: (response.success === true) ? 'success' : 'error'
                            }).show();
                            addendioPublic.forms.clear(form);
                        },
                        error: function (errorThrown) {
                            // Throw Common Server Error
                            new Noty({
                                text: addendioPublicData.messages.error.server.common,
                                type: 'error'
                            }).show();
                        },
                        complete: function () {
                            addendioPublic.ajaxSpinner.remove();
                        }
                    });
                }
            },

            formPasswordRecovery: {
                processForm: function (form) {
                    form.validate();

                    if (!form.valid()) {
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: addendioPublicData.ajaxUrl,
                        data: {
                            action: 'handle_request',
                            addendio_action: 'password_recovery',
                            addendio_data: form.serialize()
                        },
                        success: function (response) {
                            new Noty({
                                text: response.data.message,
                                type: (response.success === true) ? 'success' : 'error'
                            }).show();
                        },
                        error: function (errorThrown) {
                            // Throw Common Server Error
                            new Noty({
                                text: addendioPublicData.messages.error.server.common,
                                type: 'error'
                            }).show();
                        },
                        complete: function () {
                            addendioPublic.ajaxSpinner.remove();
                        }
                    });
                }
            },

            ajaxSpinner: {
                spinner: '<div id="spinner" class="addendio-spinner-overlay">' +
                '<div class="addendio-spinner">' +
                '<div class="addendio-rect1"></div>' +
                '<div class="addendio-rect2"></div>' +
                '<div class="addendio-rect3"></div>' +
                '<div class="addendio-rect4"></div>' +
                '<div class="addendio-rect5"></div>' +
                '</div></div>',

                add: function ($element) {
                    $element.append(addendioPublic.ajaxSpinner.spinner);
                },
                remove: function () {
                    $("#spinner").remove();
                }
            },

            forms: {
                clear: function($form) {
                    $form.find("input").val("");
                }
            }

        }
        addendioPublic.init();

    });

})(jQuery);
