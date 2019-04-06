class Ajax {


    /**
     * Create category
     * @returns {Promise<void>}
     */
    createCategory = async function () {
        $('#create-category').on('click', function (e) {
            e.preventDefault();
            let form = $('#form-category-create');
            let url = form.attr('action');
            let data = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (result) {
                    // Fermeture du modal Bootstrap 4
                    $('.modal').modal('hide').data('bs.modal', null);
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
     * Delete tag/{id}
     * @returns {Promise<void>}
     */
    deleteTag = async function () {
        $('.delete-tag').on('click', function (e) {
            e.preventDefault();
            let row = $(this).parents('tr');
            let id = row.data('id');
            let url = $('.delete-tag').attr('href').replace(':TAG_ID', id);

            $.ajax({
                type: 'DELETE',
                url: url,
                success: function (result) {
                    $('#tag_' + id).fadeOut();
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
            })
        })
    }

    /**
     * Delete category/{id}
     * @returns {Promise<void>}
     */
    deleteCategory = async function () {
        $('.delete-category').on('click', function (e) {
            e.preventDefault();
            let row = $(this).parents('tr');
            let id = row.data('id');
            let url = $('.delete-category').attr('href').replace(':CATEGORY_ID', id);

            $.ajax({
                type: 'DELETE',
                url: url,
                success: function (result) {
                    // Remove row (DOM)
                    $('#category_' + id).fadeOut();
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
     * Form edit category
     * click button edit category / {id}
     */
    editCategory = async function () {
        $('.btn-edit-category').on('click', function (e) {
            e.preventDefault();
            let row = $(this).parents().parents('tr');
            let id = row.data('id');
            let form = $('#form-edit-category-' + id);
            let url = form.attr('action').replace(':CATEGORY_ID', id);
            let data = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: data,
                success: function (result) {
                    // Close toggle
                    $('.form-edit-category-' + id).slideUp();
                    // Show the new category
                    $('#row-title-' + id).html(result.title);
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
     * User
     * Toggle
     * Enable / Disable
     * isActive field {id}
     * @returns {Promise<void>}
     */
    userToggleIsActive = async function () {
        $('.btn-toggle-is-active').on('click', function (e) {
            e.preventDefault();
            let row = $(this).parents('tr');
            let id = row.data('id');
            let url = $('#btn-toggle-is-active-' + id).attr('href').replace(':USER_ID', id);

            $.ajax({
                type: 'POST',
                url: url,
                success: function (res) {
                    // Update DOM
                    if (res.isActive == false) {
                        $('#is-active-' + id).removeClass();
                        $('#is-active-' + id).addClass('fas fa-toggle-off fa fa-2x');
                    } else {
                        $('#is-active-' + id).removeClass();
                        $('#is-active-' + id).addClass('fas fa-toggle-on fa fa-2x');
                    }
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
                            message: res.message
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

}