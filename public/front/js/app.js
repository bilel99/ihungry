/**
 * call class Ajax
 */
let ajax = new Ajax();
ajax.getRefreshProfil();
ajax.updateProfil();
ajax.updatePassword();
ajax.updateSecretPass();
ajax.accountDisable();
ajax.accountEnable();
ajax.deleteAccount();
ajax.returnCity();

$(document).ready(function () {
    $(".dropdown").hover(
        function () {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideDown("fast");
            $(this).toggleClass('open');
        },
        function () {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true, true).slideUp("fast");
            $(this).toggleClass('open');
        }
    );

    // Show form edit password / edit profil / edit secretpass /
    $('#profil-edit-secretpass').on('click', function (e) {
        e.preventDefault();
        // Show form edit secretpass
        $('.form-edit-profil').slideUp();
        $('.form-edit-password').slideUp();
        $('.form-edit-secretPass').slideDown();
        // Change menu
    });

    $('#profil-edit-password').on('click', function (e) {
        e.preventDefault();
        // show form edit password
        $('.form-edit-profil').slideUp();
        $('.form-edit-secretPass').slideUp();
        $('.form-edit-password').slideDown();
        // Change menu
        $('#li-edit-password').slideUp();
        $('#li-edit-profil').slideDown();
    });

    $('#profil-edit-account').on('click', function (e) {
        e.preventDefault();
        // show form edit profil
        $('.form-edit-password').slideUp();
        $('.form-edit-secretPass').slideUp();
        $('.form-edit-profil').slideDown();
        // Change menu
        $('#li-edit-profil').slideUp();
        $('#li-edit-password').slideDown();
    });

    // Vider le champ restaurant_libellerVille à l'appuye de la touche (delete)
    $('.restaurant_libelleVille').keyup(function (e) {
        if (e.which === 8) {
            $('.restaurant_libelleVille').val('');
        }
    });

    // Select2 Library
    $('select').select2();

    // Collection-Symfony
    // Media
    $('.my-selector').collection({
        up: '<a href="#"><i class="fas fa-arrow-circle-up"></i></a>',
        down: '<a href="#"><i class="fas fa-arrow-circle-down"></i></a>',
        add: '<a href="#"><i class="fas fa-plus-circle"></i></a>',
        remove: '<a href="#"><i class="fas fa-minus-circle"></i></a>',
        duplicate: '<a href="#"><i class="fas fa-clone"></i></a>'
    });


});

/**
 * class="active" for navigation bar in current page
 */
let activeCurrentPage = function () {
    // get url
    let pathname = window.location.pathname;
    let path = pathname.substring(1);

    if (path == '') {
        path = 'accueil';
    }

    let attribute = $('.' + path).attr('class');
    attribute = attribute.substring(9);
    if (path == attribute) {
        // Active class
        $('.nav-item.' + attribute).addClass('active');
    }
}