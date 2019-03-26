class Ajax {

    /**
     * Refresh Page account Synchronize
     * send isActive,
     * @returns {Promise<void>}
     */
    getRefreshProfil = async function () {
        let url = $('#url-profil-ajax').attr('href');
        $.ajax({
            type: 'GET',
            url: url,
            beforeSend: function () {
                // Loading animate font
            },
            success: function (result) {
                // Modification DOM
                if (result.isActive == true) {
                    $('.form-edit-profil').slideDown();
                    $('.li-delete-account').slideDown();
                    $('.li-enable-account').slideUp();
                    $('.li-disable-account').slideDown();
                } else {
                    $('.li-delete-account').slideDown();
                    $('.li-disable-account').slideUp();
                    $('.li-enable-account').slideDown();
                }
            }, error() {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Error Ajax Request!'
                });
            }
        });
    }

    /**
     * Update profil/{id}
     * @returns {Promise<void>}
     */
    updateProfil = async function () {
        $('#update-profil').on('click', function (e) {
            e.preventDefault();
            let form = $('#form-profil-edit');
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (result) {
                    // Affichage du message
                    $('.iziToast-message').append(
                        iziToast.success({
                            position: 'topRight', // center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                            progressBarColor: '',
                            backgroundColor: '',
                            messageSize: '',
                            messageColor: '',
                            icon: 'fas fa-check',
                            image: '',
                            imageWidth: 50,
                            balloon: true,
                            drag: true,
                            progressBar: true,
                            timeout: 6000,
                            title: 'Success',
                            message: result.message
                        })
                    );
                }, error: function () {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Error Ajax Request!'
                    });
                }
            });
        });
    }

    /**
     * Update password/{id}
     * @returns {Promise<void>}
     */
    updatePassword = async function () {
        $('#update-password').on('click', function (e) {
            e.preventDefault();
            let form = $('#form-profil-updatePassword');
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function (result) {
                    if (result.validator == true) {
                        // Affichage du message
                        $('.iziToast-message').append(
                            iziToast.success({
                                position: 'topRight', // center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                progressBarColor: '',
                                backgroundColor: '',
                                messageSize: '',
                                messageColor: '',
                                icon: 'fas fa-check',
                                image: '',
                                imageWidth: 50,
                                balloon: true,
                                drag: true,
                                progressBar: true,
                                timeout: 6000,
                                title: 'Success',
                                message: result.message
                            })
                        );
                    } else {
                        // Affichage du message
                        $('.iziToast-message').append(
                            iziToast.warning({
                                position: 'topRight', // center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                progressBarColor: '',
                                backgroundColor: '',
                                messageSize: '',
                                messageColor: '',
                                icon: 'fas fa-check',
                                image: '',
                                imageWidth: 50,
                                balloon: true,
                                drag: true,
                                progressBar: true,
                                timeout: 6000,
                                title: 'Ouuuups',
                                message: result.message
                            })
                        );
                    }
                }, error: function () {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Error Ajax Request!'
                    });
                }
            });

        });
    }

    /**
     * account enable, {/profil/{id}}
     * @returns {Promise<void>}
     */
    accountEnable = async function () {
        $('#enable-account').on('click', function (e) {
            e.preventDefault();
            let form = $('#form-user-enable');
            let url = form.attr('action');
            let data = form.serialize();

            Swal.fire({
                title: 'Etes vous sur',
                text: "De vouloir réactiver votre compte",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, je souhaite réactiver mon compte'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        success: function (result) {
                            // Modification DOM
                            $('.li-enable-account').slideUp();
                            $('.li-disable-account').slideDown();
                            $('.li-delete-account').slideDown();

                            // Affichage du message
                            $('.iziToast-message').append(
                                iziToast.success({
                                    position: 'topRight', // center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                    progressBarColor: '',
                                    backgroundColor: '',
                                    messageSize: '',
                                    messageColor: '',
                                    icon: 'fas fa-check',
                                    image: '',
                                    imageWidth: 50,
                                    balloon: true,
                                    drag: true,
                                    progressBar: true,
                                    timeout: 6000,
                                    title: 'Success',
                                    message: result.message
                                })
                            );
                        }, error: function () {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error Ajax Request!'
                            });
                        }
                    });
                }
            });
        });
    }


    /**
     * account disable, {/profil/{id}}
     * @returns {Promise<void>}
     */
    accountDisable = async function () {
        $('#disable-account').on('click', function (e) {
            e.preventDefault();
            let form = $('#form-user-disable');
            let url = form.attr('action');
            let data = form.serialize();

            Swal.fire({
                title: 'Etes vous sur',
                text: "De vouloir désactiver votre compte",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, je désactive mon compte'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        success: function (result) {
                            // Modification DOM
                            $('.li-disable-account').slideUp();
                            $('.li-enable-account').slideDown();
                            $('.li-delete-account').slideDown();

                            // Redirection
                            setTimeout(() => {
                                location.href = result.redirectTo;
                            }, 1500);
                            // Affichage du message
                            $('.iziToast-message').append(
                                iziToast.success({
                                    position: 'topRight', // center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                    progressBarColor: '',
                                    backgroundColor: '',
                                    messageSize: '',
                                    messageColor: '',
                                    icon: 'fas fa-check',
                                    image: '',
                                    imageWidth: 50,
                                    balloon: true,
                                    drag: true,
                                    progressBar: true,
                                    timeout: 6000,
                                    title: 'warning',
                                    message: result.message
                                })
                            );
                        }, error: function () {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error Ajax Request!'
                            });
                        }
                    });
                }
            });
        });
    }

    /**
     * delete account
     * @returns {Promise<void>}
     */
    deleteAccount = async function () {
        $('#delete-account').on('click', function (e) {
            e.preventDefault();
            let form = $('#form-user-delete');
            let url = form.attr('action');
            let data = form.serialize();

            Swal.fire({
                title: 'Etes vous sur',
                text: "De vouloir supprimer votre compte",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, je souhaite supprimer mon compte'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: data,
                        success: function (result) {
                            // Modification DOM
                            $('.li-delete-account').slideUp();
                            $('.li-disable-account').slideUp();
                            $('.li-enable-account').slideUp();

                            // Redirection
                            setTimeout(() => {
                                location.href = result.redirectTo;
                            }, 1500);
                            // Affichage du message
                            $('.iziToast-message').append(
                                iziToast.success({
                                    position: 'topRight', // center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                    progressBarColor: '',
                                    backgroundColor: '',
                                    messageSize: '',
                                    messageColor: '',
                                    icon: 'fas fa-check',
                                    image: '',
                                    imageWidth: 50,
                                    balloon: true,
                                    drag: true,
                                    progressBar: true,
                                    timeout: 6000,
                                    title: 'warning',
                                    message: result.message
                                })
                            );
                        }, error: function () {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Error Ajax Request!'
                            });
                        }
                    });
                }
            });
        });
    }

}