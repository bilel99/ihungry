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
    /**
     * Hide navbar is scroll down
     * Show navbar is scroll up
     */
    hideOnScrollNavBar();

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

/**
 * Hide navbar is scroll down
 * Show navbar is scroll up
 */
let hideOnScrollNavBar = function () {
    let new_scroll_position = 0;
    let last_scroll_position;
    let navbar = document.getElementById("navbar");

    window.addEventListener('scroll', function (e) {
        last_scroll_position = window.scrollY;
        // Scrolling down
        if (new_scroll_position < last_scroll_position && last_scroll_position > 80) {
            navbar.classList.remove("slideDown");
            navbar.classList.add("slideUp");
            // Scrolling up
        } else if (new_scroll_position > last_scroll_position) {
            navbar.classList.remove("slideUp");
            navbar.classList.add("slideDown");
        }
        new_scroll_position = last_scroll_position;
    });
}